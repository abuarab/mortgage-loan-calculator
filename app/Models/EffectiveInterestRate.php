<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EffectiveInterestRate extends Model
{
    protected $fillable = [
        'loan_id',
        'effective_interest_rate',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
