@extends('layouts.app')

@section('title', 'Blocked Games')

@section('content')

<div class="container">
    <h1>Blocked Games</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Owner</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blockedGames as $game)
                <tr>
                    <td>{{ $game->name }}</td>
                    <td>{{ $game->seller->name }}</td>
                    <td>
                        <form action="{{ route('admin.games.unblock', $game->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Unblock</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $blockedGames->links() }}
</div>

@endsection