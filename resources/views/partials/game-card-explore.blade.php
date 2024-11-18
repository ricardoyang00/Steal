<div class="card">
    <div class="row g-0">
        <div class="col-md-3">
            <a href="{{ route('game.details', ['id' => $game->id]) }}">
                <img src="{{ asset('images/default-game-image.jpg') }}" class="card-img-top" alt="{{ $game->name }}" height=200px>
            </a>
        </div>
        <div class="col-md-6">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">
                        <a href="{{ route('game.details', ['id' => $game->id]) }}" class="text-decoration-none text-dark">
                            {{ $game->name }}
                        </a>
                    </h5>
                    <p>{{ \Carbon\Carbon::parse($game->release_date)->format('d M, Y') }}</p>
                    <p class="card-text"><strong>Rating:</strong> {{ $game->overall_rating }}%</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="d-flex justify-content-between mt-auto">
                <p class="card-text"><strong>Price:</strong> ${{ number_format($game->price, 2) }}</p>
                <button id="add-to-cart-{{ $game->id }}" data-id="{{ $game->id }}" class="btn-add-to-cart btn btn-primary">Add to Cart</button>
            </div>
        </div>
    </div>
</div>