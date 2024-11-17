<!DOCTYPE html>
<html>
    <head>
        <title>Shopping Cart</title>
    </head>
    <body>
        <h1>Shopping Cart</h1>
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
    </body>
</html>