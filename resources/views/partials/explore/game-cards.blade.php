<div class="game-cards">
    @if(request('query'))
        <p class="text-center">
            {{ $games->total() }} {{ $games->total() == 1 ? 'result matches' : 'results match' }} your search.
        </p>
    @endif
    @if($games->isEmpty())
        <p class="text-center">No games found.</p>
    @endif
    @foreach($games as $game)
        @include('partials.explore.game-card-explore', ['game' => $game])
    @endforeach
</div>

<!-- Pagination Links -->
<div class="pagination-links">
    {{ $games->appends(request()->except('page'))->links() }}
</div>