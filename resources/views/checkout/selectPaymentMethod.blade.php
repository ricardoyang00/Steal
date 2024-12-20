@extends('layouts.app')

@section('content')

<script src="{{ asset('js/cart/select-payment-method.js') }}" defer></script>

<div class="payment-method-selection-container">
    
    <form action="{{ route('checkout.confirmPayment') }}" method="POST">
        @csrf
        <div class="payment-method-form">
            <p class="payment-method-form-paragraph">Select your payment method:</p>

            <div class="row">
                @foreach ($paymentMethods as $method)
                    <div class="col-12 col-md-4">
                        <div class="card payment-method-card" data-method-id="{{ $method->id }}">
                            <div class="card-body d-flex flex-column align-items-center">
                                <h5 class="card-title">{{ $method->name }}</h5>
                                <img src="{{ asset($method->image_path) }}" alt="{{ $method->name }}">
                                <div class="form-check">
                                    <input 
                                        type="radio" 
                                        id="payment_method_{{ $method->id }}" 
                                        name="payment_method" 
                                        value="{{ $method->id }}" 
                                        class="form-check-input"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="payment-method-submission text-center mt-4">
            <button type="submit" class="btn btn-primary me-2">Confirm Payment Method</button>
            <a href="{{ route('shopping_cart') }}" class="btn btn-secondary">Go Back to Cart</a>
        </div>
    </form>
</div>
@endsection



