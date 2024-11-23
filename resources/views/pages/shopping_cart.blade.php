@extends('layouts.app')

@section('title', 'Cart')

@section('content')

<script src="{{ asset('js/cart/cart.js') }}" defer></script>

<section id="shopping_cart">
    <div class="cart-container">
        <div class="cart">
            <h2>Cart</h2>
            <div class="cart-items">
                @if (count($products) == 0)
                    <p>No products in the cart.</p>
                @else
                    <ul id="product_list">
                        @foreach ($products as $product)
                            <li id="product-{{ $product['id'] }}">
                                <div class="product-container">
                                    <img src="{{ asset('images/default-game-poster.jpg') }}" class="img-fluid" alt="{{ $product['name'] }}">
                                    <div class="product-details">
                                        <p class="product-name">{{ $product['name'] }}</p>
                                        <button class="btn-remove" data-id="{{ $product['id'] }}">
                                            <i class="far fa-trash-alt"></i> Remove
                                        </button>
                                    </div>
                                    <div class="product-actions">
                                        <p class="product-price">{{ $product['price'] }}€</p>
                                        <div class="quantity-controls">
                                            <button class="btn-decrease" data-id="{{ $product['id'] }}">-</button>
                                            <span class="prod_quantity">{{ $product['quantity'] }}</span>
                                            <button class="btn-increase" data-id="{{ $product['id'] }}">+</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="summary">
            <h2>Summary</h2>
            <div class="cart-summary">
                <p>Official price: <span id="total_price">{{ $total }}€</span></p>
                <p>Discount: <span id="discount">-0.00€</span></p>
                <p>Subtotal: <span id="subtotal">{{ $total }}€</span></p> <!-- Later change cart.js updateQuantity function so subtotal is calculated with discounts -->
                @if (auth_user())
                    @if (auth_user()->buyer)
                        <button id="checkout_button" data-authenticated="true">Checkout</button>
                    @endif
                @else
                    <button id="checkout_button" data-authenticated="false">Checkout</button>
                @endif
                <button class="continue-shopping" onclick="window.location.href = '{{ route('home') }}';">continue-shopping</button>
            </div>
        </div>
    </div>
</section>

@endsection