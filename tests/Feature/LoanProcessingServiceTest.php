<?php

namespace Tests\Feature;

use App\Services\LoanProcessingService;
use App\Repositories\LoanRepositoryInterface;
use App\Models\Loan;
use Tests\TestCase;

class LoanProcessingServiceTest extends TestCase
{
    public function testAddExtraPayment()
    {
        $loanRepositoryMock = $this->getMockBuilder(LoanRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $loanRepositoryMock->method('getById')
            ->willReturn(new Loan([
                'id' => 1,
                'amount' => 10000,
                'annual_interest_rate' => 5,
                'term' => 12,
            ]));

        $loanProcessingService = new LoanProcessingService($loanRepositoryMock);

        $request = new \Illuminate\Http\Request([
            'loan_id' => 1,
            'extra_payment_amount' => 500,
            'month_number' => 6,
        ]);

        $response = $loanProcessingService->addExtraPayment($request);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

    }
}
