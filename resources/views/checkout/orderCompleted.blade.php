@extends('layouts.app')

@section('title', 'Order Completed')

@section('content')
<div class="container text-center mt-5">
    <h1 class="text-success">Order Completed Successfully!</h1>
    <p class="lead mt-3">
        Thank you for your purchase. Your order has been completed successfully.
    </p>

    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn btn-primary">Go Back Home</a>
    </div>
</div>
@endsection

