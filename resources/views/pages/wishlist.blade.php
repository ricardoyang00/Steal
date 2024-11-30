@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')

<script src="{{ asset('js/cart/add-to-cart.js') }}" defer ></script>
<script src="{{ asset('js/wishlist/wishlist.js') }}" defer></script>

<section id="wishlist">
    <div class="wishlist-container"> 
        <div class="wishlist">
            <h2>Wishlist</h2>
            <div id="wishlist_id" class="wishlist-items {{ count($products) == 0 ? 'empty-wishlist' : '' }}">
                @if (count($products) == 0)
                    <div class="empty-wishlist-message">
                        <i class="fas fa-heart"></i>
                        <p id="primary-empty-message">Your wishlist is empty.</p>
                        <p id="secondary-empty-message">You have no item in your wishlist yet. Browse the website to find amazing deals!</p>
                        <a href="{{ route('explore') }}" class="btn">Explore games</a>
                    </div>
                @else
                    <ul id="product_list">
                        @foreach ($products as $product)
                            <li id="product-{{ $product['id'] }}">
                                <div class="product-container">
                                    <a href="{{ route('game.details', ['id' => $product['id']]) }}">
                                        <img src="{{ asset('images/default-game-poster.jpg') }}" class="img-fluid" alt="{{ $product['name'] }}">
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
                                        @if (!auth_user() || auth_user()->buyer)
                                            <button id="add-to-cart-{{ $product['id'] }}" data-id="{{ $product['id'] }}" class="btn-add-to-cart btn btn-primary">
                                                Add to Cart
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection