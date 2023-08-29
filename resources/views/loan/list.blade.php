@extends('layouts.app')

@section('content')
    <div class="container">
            <table class="table">
                <thead>
                <tr>
                    <th>Amount</th>
                    <th>Interest Rate</th>
                    <th>Term (Months)</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($loans as $loan)
                    <tr>
                        <td>{{ $loan->amount }}</td>
                        <td>{{ $loan->annual_interest_rate }}</td>
                        <td>{{ $loan->term }}</td>
                        <td>
                            <a href="{{ route('loan.show', ['loan' => $loan]) }}" class="btn btn-primary">View Details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
    </div>
    </div>
@endsection
