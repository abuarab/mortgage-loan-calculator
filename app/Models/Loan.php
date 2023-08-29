<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoanAmortizationSchedule;
use App\Models\ExtraRepaymentSchedule;

class Loan extends Model
{
    protected $fillable = [
        'amount',
        'annual_interest_rate',
        'term',
        'monthly_fixed_extra_payment',
    ];

    public function amortizationSchedules()
    {
        return $this->hasMany(AmortizationSchedule::class);
    }

    public function extraRepaymentSchedules()
    {
        return $this->hasMany(ExtraRepaymentSchedule::class);
    }
}
