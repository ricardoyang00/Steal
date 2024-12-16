@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')

<script src="{{ asset('js/cart/add-to-cart.js') }}" defer ></script>
<script src="{{ asset('js/wishlist/wishlist.js') }}" defer></script>

<section id="wishlist">
    <div class="wishlist-container"> 
        <div class="wishlist">
            <div id="wishlist_id" class="wishlist-items {{ count($products) == 0 ? 'empty-wishlist' : '' }}">
                @if (count($products) == 0)
                    <div class="empty-wishlist-message">
                        <i class="fas fa-heart"></i>
                        <p id="primary-empty-message">Your wishlist is empty.</p>
                        <p id="secondary-empty-message">Time to fill it up with epic deals! Browse now and snag your next favorite game at an unbeatable price!</p>
                        <a href="/explore" class="btn">Explore games</a>
                    </div>
                @else
                    <div class="wishlist-header">
                        <i class="fas fa-heart"></i>
                        <h2>Wishlist</h2>
                    </div>
                    <ul id="product_list">
                        @foreach ($products as $product)
                            @if ($product['is_active'])
                                <li id="product-{{ $product['id'] }}">
                                    <div class="product-container">
                                        <a href="{{ route('game.details', ['id' => $product['id']]) }}">
                                            <img src="{{ asset($product['thumbnail_large_path']) }}" class="img-fluid" alt="{{ $product['name'] }}">
                                        </a>
                                        <div class="product-details">
                                            <a href="{{ route('game.details', ['id' => $product['id']]) }}">
                                                <p class="product-name">{{ $product['name'] }}</p>
                                            </a>
                                            <div class="game-tags">
                                                @foreach($product['categories'] as $category)
                                                    <span class="tag">{{ $category }}</span>
                                                @endforeach
                                                @foreach($product['players'] as $player)
                                                    <span class="tag">{{ $player }}</span>
                                                @endforeach
                                            </div>
                                            <button class="btn-remove" data-id="{{ $product['id'] }}">
                                                <i class="far fa-trash-alt"></i> Remove
                                            </button>
                                        </div>
                                        <div class="product-actions">
                                            <p class="product-price">€{{ $product['price'] }}</p>
                                            @if (!auth_user() || auth_user()->buyer)
                                                <button id="add-to-cart-{{ $product['id'] }}" data-id="{{ $product['id'] }}" class="btn-add-to-cart btn btn-primary">
                                                    Add to Cart
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection