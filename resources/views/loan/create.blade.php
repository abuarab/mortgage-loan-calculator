@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Request New Loan</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="loan_amount" class="form-label">Loan Amount *</label>
                                <input type="number" class="form-control" id="loan_amount" name="loan_amount" step="any" required>
                            </div>

                            <div class="mb-3">
                                <label for="interest_rate" class="form-label">Interest Rate *</label>
                                <div class="input-group">
                                    <input type="number" step="any" min="1" max="100" class="form-control" id="interest_rate" name="interest_rate" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="loan_term" class="form-label">Loan Term *</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="loan_term" name="loan_term" required>
                                    <span class="input-group-text">years</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="extra_payment" class="form-label">Extra Payment</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="extra_payment" name="extra_payment">
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
