@extends('layouts.app')

@section('title', 'Buyers and Sellers')

@section('content')

<h1 id="all-users">All Users</h1>

<div class="list-buyers-sellers">
    <div class="user-list">
        <h2>Buyers</h2>
        @if ($buyers->isEmpty())
            <p>No buyers found.</p>
        @else
            <ul>
                @foreach ($buyers as $buyer)
                    <li>
                        <a href="{{ route('admin.users.profile', $buyer->id) }}">{{ $buyer->username }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="user-list">
        <h2>Sellers</h2>
        @if ($sellers->isEmpty())
            <p>No sellers found.</p>
        @else
            <ul>
                @foreach ($sellers as $seller)
                    <li>
                        <a href="{{ route('admin.users.profile', $seller->id) }}">{{ $seller->username }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

@endsection