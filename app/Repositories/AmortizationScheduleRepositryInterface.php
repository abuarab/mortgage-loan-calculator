<?php

namespace App\Repositories;

interface AmortizationScheduleRepositryInterface
{
    public function getAmortizationScheduleByLoanId($loanId);

}
