@extends('layouts.app')

@section('title', 'Weekly Sales Report')

@section('content')
<div class="container mt-5">
    <h1>Weekly Sales Report</h1>
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
</div>
@endsection