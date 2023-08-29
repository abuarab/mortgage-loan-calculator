<?php

namespace App\Http\Controllers;

use App\Services\LoanProcessingService;
use Illuminate\Http\Request;
use App\Repositories\LoanRepositoryInterface;
use App\Repositories\AmortizationScheduleRepositryInterface;
use App\Repositories\ExtraRepaymentSchedulesRepositryInterface;

class ProcessLoansController extends Controller
{

    protected $loanProcessingService;

    protected $loanRepository;

    protected $amortizationScheduleRepositry;

    protected $extraRepaymentSchedulesRepositry;

    public function __construct(
        LoanProcessingService $loanProcessingService,
        LoanRepositoryInterface $loanRepository,
        AmortizationScheduleRepositryInterface $amortizationScheduleRepositry,
        ExtraRepaymentSchedulesRepositryInterface $extraRepaymentSchedulesRepositry
    )
    {
        $this->loanProcessingService = $loanProcessingService;
        $this->loanRepository = $loanRepository;
        $this->amortizationScheduleRepositry = $amortizationScheduleRepositry;
        $this->extraRepaymentSchedulesRepositry = $extraRepaymentSchedulesRepositry;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $this->validate($request, [
                'loan_amount' => 'required|numeric|min:1',
                'interest_rate' => 'required|numeric|min:0',
                'loan_term' => 'required|integer|min:1',
                'extra_payment' => 'nullable|numeric|min:0',
            ]);

            return $this->loanProcessingService->execute($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('loan.create')->withErrors($e->errors())->withInput();
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function showLoans()
    {
        $loans = $this->loanRepository->getAll();

        return view('loan.list', compact('loans'));
    }

    /**
     * @param $loan
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function details($loan) {

        $amortizationSchedule= $this->amortizationScheduleRepositry->getAmortizationScheduleByLoanId($loan);

        $extraRepaymentSchedules = $this->extraRepaymentSchedulesRepositry->getExtraRepaymentSchedulesByLoanId($loan);

        $loan = $this->loanRepository->getById($loan);

        return view('loan.details', compact('loan', 'amortizationSchedule', 'extraRepaymentSchedules'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addExtraPayment(Request $request)
    {
        return $this->loanProcessingService->addExtraPayment($request);
    }
}
