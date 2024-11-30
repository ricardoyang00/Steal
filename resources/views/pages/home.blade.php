@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section id="home">
        <h1>Top 5 Top-Sellers Games</h1>

        @foreach ($topSellers as $game)
            <div>
                <h2><a href="{{ route('game.details', $game->id) }}">{{ $game->name }}</a></h2>

                <h3>Similar Games</h3>
                <ul>
                    @foreach ($similarGames[$game->id] as $similarGame)
                        <li>
                            <a href="{{ route('game.details', $similarGame->id) }}">{{ $similarGame->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

    </section>
@endsection