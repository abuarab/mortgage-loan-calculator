<?php

namespace App\Providers;

use App\Repositories\AmortizationScheduleRepositryInterface;
use App\Repositories\ExtraRepaymentSchedulesRepositryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\LoanRepositoryInterface;
use App\Repositories\MysqlLoanRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoanRepositoryInterface::class, MysqlLoanRepository::class);
        $this->app->bind(AmortizationScheduleRepositryInterface::class, MysqlLoanRepository::class);
        $this->app->bind(ExtraRepaymentSchedulesRepositryInterface::class, MysqlLoanRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
