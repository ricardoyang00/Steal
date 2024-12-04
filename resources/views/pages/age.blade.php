@extends('layouts.app')

@section('title', $age->name)

@section('content')
<div class="container mt-5">
    <h1>{{ $age->name }}</h1>
    <p><strong>Minimum Age:</strong> {{ $age->minimum_age }}</p>
    <p><strong>Description:</strong> {{ $age->description }}</p>
    <img src="{{ asset($age->image_path) }}" alt="{{ $age->name }}" class="img-fluid">
    <p>More information in: <a href="https://pegi.info/" target="_blank">https://pegi.info/</a></p>
</div>
@endsection