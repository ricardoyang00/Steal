@extends('layouts.app')

@section('title', 'Daily Sales Report')

@section('content')
<div class="container mt-5">
    <h1>Daily Sales Report</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Game</th>
                <th>Value</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->getcdk->getgame->name }}</td>
                    <td>{{ $sale->getpurchase->value }}</td>
                    <td>{{ \Carbon\Carbon::parse($sale->getpurchase->getorder->time)->format('d/m/y H:i:s') }}</td>
                    <td><a href="{{ route('admin.purchases.details', ['id' => $sale->getpurchase->id]) }}" class="btn btn-info">Details</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection