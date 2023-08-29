<?php

namespace App\Repositories;

use App\Models\Loan;
use Illuminate\Support\Collection;

interface LoanRepositoryInterface
{
    public function save(Loan $loan);

    public function getAll(): Collection;

    public function getById($loanId): ?Loan;
}
