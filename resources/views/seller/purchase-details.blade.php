@extends('layouts.app')

@section('title', 'Purchase Details')

@section('content')
<div class="container mt-5">
    <h1>Purchase Details</h1>

    <div class="purchase-details">
        <p><strong>CDK:</strong> {{ $purchase->cdk_code }}</p>
        <p><strong>Buyer Name:</strong> {{ $purchase->buyer_name }}</p>
        <p><strong>Buyer Email:</strong> {{ $purchase->buyer_email }}</p>
        <p><strong>Value:</strong> €{{ number_format($purchase->value, 2) }}</p>
        <p><strong>Purchase Date:</strong> {{ \Carbon\Carbon::parse($purchase->time)->format('d/m/Y H:i:s') }}</p>
        <p><strong>Payment Method:</strong>
            {{ $purchase->payment_method_name }}
            <img src="{{ asset($purchase->payment_method_image) }}" alt={{ $purchase->payment_method_name }} style="width:1.54em;">
        </p>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
</div>
@endsection