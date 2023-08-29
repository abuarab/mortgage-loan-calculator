<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanAmortizationSchedule extends Model
{

    protected $table = 'amortization_schedules';

    protected $fillable = [
        'loan_id',
        'month_number',
        'starting_balance',
        'monthly_payment',
        'principal_component',
        'interest_component',
        'ending_balance',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
