@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Checkout</h1>

    <h2 class="my-4">Select Your Payment Method</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('checkout.confirmPayment') }}" method="POST">
        @csrf

        <div class="form-group">
            <p>Please choose your preferred payment method:</p>
            @foreach ($paymentMethods as $method)
                <div class="form-check mb-3">
                    <label for="payment_method_{{ $method->id }}" class="form-check-label d-block">
                        {{ $method->name }}
                    </label>
                    <input 
                        type="radio" 
                        id="payment_method_{{ $method->id }}" 
                        name="payment_method" 
                        value="{{ $method->id }}" 
                        class="form-check-input">
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Confirm Payment Method</button>
            <a href="{{ route('shopping_cart') }}" class="btn btn-secondary">Go Back to Cart</a>
        </div>
    </form>
</div>
@endsection

