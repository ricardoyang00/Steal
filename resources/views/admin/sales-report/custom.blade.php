@extends('layouts.app')

@section('title', 'Custom Sales Report')

@section('content')
<div class="container mt-5">
    <h1>Custom Sales Report</h1>
    <form action="{{ route('admin.salesReport.custom') }}" method="GET">
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    @if(isset($sales))
        <h2>Sales from {{ $startDate->format('Y-m-d') }} to {{ $endDate->format('Y-m-d') }}</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Purchase ID</th>
                    <th>Game</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->game->name }}</td>
                        <td>{{ $sale->amount }}</td>
                        <td>{{ $sale->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection