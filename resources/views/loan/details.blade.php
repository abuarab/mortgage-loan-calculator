@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Loan Details
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addExtraPaymentModal">
                            Add Extra Payment
                        </button>
                    </div>

                        <div class="card-body">
                            <ul>
                                <li>Loan Amount: {{ $loan->amount }}</li>
                                <li>Annual Interest Rate: {{ $loan->annual_interest_rate }}</li>
                                <li>Loan Term: {{ $loan->term }}</li>
                                <li>Monthly Fixed Extra Payment: {{ $loan->monthly_fixed_extra_payment }}</li>
                            </ul>
                        </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Amortization Schedule</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Month</th>
                                <th>Starting Balance</th>
                                <th>Monthly Payment</th>
                                <th>Principal Component</th>
                                <th>Interest Component</th>
                                <th>Ending Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($amortizationSchedule as $entry)
                                <tr>
                                    <td>{{ $entry->month_number }}</td>
                                    <td>{{ $entry->starting_balance }}</td>
                                    <td>{{ $entry->monthly_payment }}</td>
                                    <td>{{ $entry->principal_component }}</td>
                                    <td>{{ $entry->interest_component }}</td>
                                    <td>{{ $entry->ending_balance }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Extra Repayment Schedules</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Month</th>
                                <th>Starting Balance</th>
                                <th>Extra Repayment Made</th>
                                <th>Ending Balance after Extra Repayment</th>
                                <th>Remaining Loan Term after Extra Repayment</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($extraRepaymentSchedules as $entry)
                                <tr>
                                    <td>{{ $entry->month_number }}</td>
                                    <td>{{ $entry->starting_balance }}</td>
                                    <td>{{ $entry->extra_repayment_made }}</td>
                                    <td>{{ $entry->ending_balance_after_extra_repayment }}</td>
                                    <td>{{ $entry->remaining_loan_term_after_extra_repayment }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="modal fade" id="addExtraPaymentModal" tabindex="-1" aria-labelledby="addExtraPaymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExtraPaymentModalLabel">Add Extra Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('loan.addExtraPayment')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="loan_id" value="{{$loan->id}}">
                                    <div class="mb-3">
                                        <label for="month_number" class="form-label">Month</label>
                                        <input type="number" class="form-control" id="month_number" name="month_number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="extra_payment_amount" class="form-label">Extra Payment</label>
                                        <input type="number" class="form-control" id="extra_payment_amount" name="extra_payment_amount" step="0.01" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
