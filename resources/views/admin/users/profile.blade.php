@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<h1>Profile</h1>
<p><strong>User ID:</strong> {{ $user->id }}</p>
<p><strong>Username:</strong> {{ $user->username }} <button onclick="document.getElementById('change-username-form').submit();">Change Innapropriate Username</button></p>
<p><strong>Name:</strong> {{ $user->name }} <button onclick="document.getElementById('change-name-form').submit();">Change Innapropriate Name</button></p>
<p><strong>Email:</strong> {{ $user->email }}</p>
<p><strong>Status:</strong> {{ $user->is_active ? 'Active' : 'Disabled' }}</p>
@if ($user->buyer)
    <p><strong>Role:</strong> Buyer</p>
    <p><strong>NIF:</strong> {{ $user->buyer->nif ?? 'NONE' }}</p>
    <p><strong>Birth Date:</strong> {{ $user->buyer->birth_date }}</p>
    <p><strong>Coins:</strong> {{ $user->buyer->coins }}</p>
@elseif ($user->seller)
    <p><strong>Role:</strong> Seller</p>
    <p><strong>Seller Information:</strong> This user is a seller.</p>
@endif

<form id="change-username-form" method="POST" action="{{ route('admin.users.changeUsername', $user->id) }}">
    {{ csrf_field() }}
</form>

<form id="change-name-form" method="POST" action="{{ route('admin.users.changeName', $user->id) }}">
    {{ csrf_field() }}
</form>

@endsection