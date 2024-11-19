@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <section id="shopping_cart">
        <h1>Shopping Cart</h1>
        @if (count($products) == 0)
            <p>No products in the cart.</p>
        @else
        <div id="product_div">
            <p>Products:</p>
            <ul id="product_list">
                @foreach ($products as $product)
                    <li id="product-{{ $product['id'] }}">
                        {{ $product['name'] }} - ${{ $product['price'] }} 

                        <button class="btn-decrease" data-id="{{ $product['id'] }}">-</button>
                        <span class="prod_quantity">{{ $product['quantity'] }}</span>
                        <button class="btn-increase" data-id="{{ $product['id'] }}">+</button>
                        <button class="btn-remove" data-id="{{ $product['id'] }}">Remove</button>
                    </li>
                @endforeach
            </ul>
            <p>Total: $<span id="total_price">{{ $total }}</span></p>
        </div>
        @endif
        <button onclick="window.location.href = '{{ route('home') }}';">Go Back Home</button>
        <script src="{{ asset('js/cart/cart.js') }}" defer></script>
    </section>
@endsection