<?php
namespace App\Services;

use App\Models\ExtraRepaymentSchedule;
use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;
use App\Models\EffectiveInterestRate;
use App\Repositories\LoanRepositoryInterface;
use Illuminate\Support\Facades\Redirect;


class LoanProcessingService
{
    /*** @var LoanRepositoryInterface */
    protected $loanRepository;

    public function __construct(LoanRepositoryInterface $loanRepository) {
        $this->loanRepository = $loanRepository;
    }

    public function execute($request)
    {

        try {
            $loan = new Loan([
                'amount' => $request->loan_amount,
                'annual_interest_rate' => $request->interest_rate,
                'term' => $request->loan_term * 12,
                'monthly_fixed_extra_payment' => $request->extra_payment,
            ]);

            if ($newLoan = $this->loanRepository->save($loan)) {
                $amortizationData = $this->calculateAmortizationSchedule($newLoan);

                LoanAmortizationSchedule::insert($amortizationData);

                EffectiveInterestRate::create([
                    'loan_id' => $newLoan->id,
                    'effective_interest_rate' => $newLoan->annual_interest_rate,
                ]);

                return Redirect::route('loan.list')->with('success', 'Loan added successfully.');
            } else {
                return Redirect::route('loan.create')->with('error', 'Failed to add loan. Please try again.');
            }
        } catch (\Exception $e) {
            return Redirect::route('loan.create')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function calculateAmortizationSchedule(Loan $loan)
    {
        $monthlyInterestRate = ($loan->annual_interest_rate / 12) / 100;
        $numberOfMonths = $loan->term;
        $monthlyPayment = ($loan->amount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfMonths));

        $amortizationData = [];
        $remainingBalance = $loan->amount;

        for ($month = 1; $month <= $numberOfMonths; $month++) {
            $interestComponent = $remainingBalance * $monthlyInterestRate;
            $principalComponent = $monthlyPayment - $interestComponent;

            $amortizationData[] = [
                'loan_id' => $loan->id,
                'month_number' => $month,
                'starting_balance' => $remainingBalance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalComponent,
                'interest_component' => $interestComponent,
                'ending_balance' => $remainingBalance - $principalComponent,
            ];

            $remainingBalance -= $principalComponent;
        }

        return $amortizationData;
    }

    public function addExtraPayment($request)
    {
        $request->validate([
            'loan_id' => 'required|numeric',
            'extra_payment_amount' => 'required|numeric|min:0',
            'month_number' => 'required|numeric|min:1',
        ]);

        $loan = $this->loanRepository->getById($request->loan_id);

        if (!$loan) {
            return redirect()->back()->with('error', 'Loan not found.');
        }

        $extraPaymentAmount = $request->extra_payment_amount;
        $monthNumber = $request->month_number;

        $amortizationSchedule = $this->calculateAmortizationSchedule($loan);
        $remainingBalanceAfterExtraPayment = $amortizationSchedule[$monthNumber - 1]['ending_balance'] - $extraPaymentAmount;

        $startingBalance = $remainingBalanceAfterExtraPayment;

        for ($i = $monthNumber; $i <= $loan->term; $i++) {
            $amortizationSchedule[$i - 1]['starting_balance'] = $remainingBalanceAfterExtraPayment;
            $interestComponent = $remainingBalanceAfterExtraPayment * ($loan->annual_interest_rate / 12) / 100;
            $principalComponent = $amortizationSchedule[$i - 1]['monthly_payment'] - $interestComponent;
            $remainingBalanceAfterExtraPayment -= $principalComponent;
            $amortizationSchedule[$i - 1]['principal_component'] = $principalComponent;
            $amortizationSchedule[$i - 1]['interest_component'] = $interestComponent;
            $amortizationSchedule[$i - 1]['ending_balance'] = $remainingBalanceAfterExtraPayment;
            $startingBalance = $remainingBalanceAfterExtraPayment;
        }

        ExtraRepaymentSchedule::create([
            'loan_id' => $loan->id ?? $request->loan_id,
            'month_number' => $monthNumber,
            'starting_balance' => $startingBalance,
            'monthly_payment' => $amortizationSchedule[$monthNumber - 1]['monthly_payment'],
            'principal_component' => $amortizationSchedule[$monthNumber - 1]['principal_component'],
            'interest_component' => $amortizationSchedule[$monthNumber - 1]['interest_component'],
            'extra_repayment_made' => $extraPaymentAmount,
            'ending_balance_after_extra_repayment' => $remainingBalanceAfterExtraPayment,
            'remaining_loan_term_after_extra_repayment' => $loan->term - $monthNumber + 1,
        ]);

        return redirect()->back()->with('success', 'Extra payment added successfully.');
    }
}
