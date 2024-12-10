@extends('layouts.app')

@section('title', 'Blocked Games')

@section('content')

<script src="{{ asset('js/common/confirmation-modal.js') }}" defer></script>
@include('partials.common.confirmation-modal')

<div class="blocked-games-container">
    <h1>Blocked Games</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Game ID</th>
                <th>Name</th>
                <th>Owner</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blockedGames as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>
                        <a href="{{ route('game.details', ['id' => $game->id]) }}">
                            {{ $game->name }}
                        </a>
                    </td>
                    <td>{{ $game->seller->name }}</td>
                    <td>{{ $game->block_reason ?? 'N/A' }}</td>
                    <td>{{ $game->block_time ? $game->block_time->format('Y-m-d H:i:s') : 'N/A' }}</td>
                    <td>
                        <form action="{{ route('admin.games.unblock', $game->id) }}" method="POST" style="display:inline;" id="unblock-game-form">
                            @csrf
                            <button type="button" class="confirmation-btn" id="btn-unblock"
                                    data-title="Unblock Game"
                                    data-message="Are you sure you want to unblock {{ $game->name }} ?"
                                    data-form-id="unblock-game-form">
                                Unblock
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $blockedGames->links() }}
</div>

@endsection