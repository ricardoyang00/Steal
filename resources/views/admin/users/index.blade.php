@extends('layouts.app')

@section('title', 'User Search Results')

@section('content')

<div class="admin-user-index">
    <h1>User Search Results</h1>
    <div class="button-container">
        <a class="list-all-users" href="{{ route('admin.users.all') }}">List All Users</a>
    </div>
    <form method="GET" action="{{ route('admin.users.search') }}">
        <input type="text" name="user_query" placeholder="Input username or email..." value="{{ request('user_query') }}">
        <button type="submit">Search</button>
    </form>

    @if (request('user_query'))
        @if ($users->isEmpty())
            <p>No users found.</p>
        @else
            <ul>
                @foreach ($users as $user)
                    <li>
                        <a href="{{ route('admin.users.profile', $user->id) }}">{{ $user->username }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif
</div>

@endsection