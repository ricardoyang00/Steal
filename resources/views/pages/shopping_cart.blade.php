@extends('layouts.app')

@section('title', 'Cart')

@section('content')

<script src="{{ asset('js/cart/cart.js') }}" defer></script>

<section id="shopping_cart">
    <div class="cart-container">
        <div class="cart">
            <h2>Cart</h2>
            <div class="cart-items {{ count($products) == 0 ? 'empty-cart' : '' }}">
                @if (count($products) == 0)
                    <div class="empty-cart-message">
                        <i class="fas fa-shopping-cart"></i>
                        <p id="primary-empty-message">Your cart is empty</p>
                        <p id="secondary-empty-message">You didn't add any item in your cart yet. Browse the website to find amazing deals!</p>
                        <a href="{{ route('explore') }}" class="btn">Explore games</a>
                    </div>
                @else
                    <ul id="product_list">
                        @foreach ($products as $product)
                            <li id="product-{{ $product['id'] }}">
                                <div class="product-container">
                                    <a href="{{ route('game.details', ['id' => $product['id']]) }}">
                                        <img src="{{ asset('images/' . $product['thumbnail_small_path']) }}" class="img-fluid" alt="{{ $product['name'] }}">
                                    </a>
                                    <div class="product-details">
                                        <a href="{{ route('game.details', ['id' => $product['id']]) }}">
                                            <p class="product-name">{{ $product['name'] }}</p>
                                        </a>
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
                <p class="price-item grey-text">Official price<span id="total_price">{{ $total }}€</span></p>
                <p class="price-item grey-text">Discount<span id="discount">-0.00€</span></p>
                <p class="price-item subtotal">Subtotal<span id="subtotal">{{ $total }}€</span></p> <!-- Later change cart.js updateQuantity function so subtotal is calculated with discounts -->
                @if (count($products) == 0)
                    <button id="checkout_button" class="disabled" data-authenticated="false" disabled>Checkout <span class="forward-symbol">&rsaquo;</span></button>
                @else
                    @if (auth_user())
                        @if (auth_user()->buyer)
                            <button id="checkout_button" data-authenticated="true">Checkout <span class="forward-symbol">&rsaquo;</span></button>
                        @endif
                    @else
                        <button id="checkout_button" data-authenticated="false">Checkout <span class="forward-symbol">&rsaquo;</span></button>
                    @endif
                @endif
                <div class="separator">
                    <span>or</span>
                </div>
                <a href="{{ route('explore') }}" class="continue-shopping"><span class="back-symbol">&lsaquo;</span> Continue shopping</a>
            </div>
        </div>
    </div>
</section>

@endsection