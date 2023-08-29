<?php

namespace App\Repositories;


use App\Models\ExtraRepaymentSchedule;
use App\Models\LoanAmortizationSchedule;
use App\Models\Loan;
use Illuminate\Support\Collection;

class MysqlLoanRepository implements LoanRepositoryInterface, AmortizationScheduleRepositryInterface, ExtraRepaymentSchedulesRepositryInterface
{

    public function save(Loan $loan)
    {
        return Loan::create([
            'amount' => $loan->amount,
            'annual_interest_rate' => $loan->annual_interest_rate,
            'term' => $loan->term,
            'monthly_fixed_extra_payment' => $loan->monthly_fixed_extra_payment,
        ]);
    }

    public function getAll(): Collection
    {
        return Loan::all();
    }

    public function getById($loanId): ?Loan
    {
        return Loan::find($loanId);
    }

    public function getAmortizationScheduleByLoanId($loanId)
    {
        return LoanAmortizationSchedule::where('loan_id', $loanId)->get();
    }

    public function getExtraRepaymentSchedulesByLoanId($loanId)
    {
        return ExtraRepaymentSchedule::where('loan_id', $loanId)->get();
    }
}
