<?php

namespace App\Repositories;

interface ExtraRepaymentSchedulesRepositryInterface
{

    public function getExtraRepaymentSchedulesByLoanId($loanId);
}
