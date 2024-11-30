@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')

<section id="wishlist">
    <div class="wishlist-container"> 
        <div class="wishlist">
            <h2>Wishlist</h2>
            <div class="wishlist-items {{ count($products) == 0 ? 'empty-wishlist' : '' }}">
                @if (count($products) == 0)
                    <div class="empty-wishlist-message">
                        <i class="fas fa-heart"></i>
                        <p id="primary-empty-message">Your wishlist is empty</p>
                        <p id="secondary-empty-message">You didn't add any item in your wishlist yet. Browse the website to find amazing deals!</p>
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
                                        <button class="btn-add-to-cart" data-id="{{ $product['id'] }}">
                                            <i class="fas fa-cart-plus"></i> Add to cart
                                        </button>
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