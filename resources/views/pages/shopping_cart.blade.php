@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <section id="shopping_cart">
        <h1>Shopping Cart</h1>
        @if (count($products) == 0)
            <li>No products in cart</li>
        @else
        <p>Products:</p>
        <ul>
            @foreach ($products as $product)
                <li>
                    {{ $product['name'] }} - ${{ $product['price'] }} 

                    <form action="{{ route('increase_quantity') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="game_id" value="{{ $product['id'] }}">
                        <button type="submit">+</button>
                    </form>
                    {{ $product['quantity'] }}
                    <form action="{{ route('decrease_quantity') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="game_id" value="{{ $product['id'] }}">
                        <button type="submit">-</button>
                    </form>
                    <form action="{{ route('remove_product') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="game_id" value="{{ $product['id'] }}">
                        <button type="submit">Remove</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <p>Total: ${{ $total }}</p>
        @endif
        <button onclick="window.location.href = '{{ route('home') }}';">Go Back Home</button>
    </section>
@endsection