@extends('layouts.app')

@section('title', 'Edit Game')

@section('content')
<div class="container mt-5">
    <h1><a href=" {{ url('seller/products') }} "><i class="fa-solid fa-chevron-left" style="color: white;"></i></a>Edit Game</h1>

    <form action="{{ route('games.update', $game->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $game->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $game->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price (€)</label>
            <input type="number" name="price" class="form-control" value="{{ $game->price }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="release_date">Release Date</label>
            <input type="date" name="release_date" class="form-control" value="{{ $game->release_date }}" required>
        </div>

        <div class="form-group">
            <label for="age_id">Age Restriction</label>
            @foreach($ages as $age)
                <div class="form-check">
                    <input type="radio" name="age_id" value="{{ $age->id }}" class="form-check-input" id="age{{ $age->id }}" {{ $game->age_id == $age->id ? 'checked' : '' }}>
                    <label class="form-check-label" for="age{{ $age->id }}">
                        <img src="{{ asset($age->image_path) }}" alt="{{ $age->name }}" style="width: 50px; height: auto;">
                        {{ $age->name }}
                        <a href="{{ url('/age/' . $age->id) }}" class="btn btn-info btn-sm" target="_blank"><i class="fa-solid fa-circle-info" style="color: white;"></i></a>
                    </label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="categories">Categories</label>
            @foreach($categories as $category)
                <div class="form-check">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-check-input" id="category{{ $category->id }}" {{ in_array($category->id, $game->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="platforms">Platforms</label>
            @foreach($platforms as $platform)
                <div class="form-check">
                    <input type="checkbox" name="platforms[]" value="{{ $platform->id }}" class="form-check-input" id="platform{{ $platform->id }}" {{ in_array($platform->id, $game->platforms->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="platform{{ $platform->id }}">{{ $platform->name }}</label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="languages">Languages</label>
            @foreach($languages as $language)
                <div class="form-check">
                    <input type="checkbox" name="languages[]" value="{{ $language->id }}" class="form-check-input" id="language{{ $language->id }}" {{ in_array($language->id, $game->languages->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="language{{ $language->id }}">{{ $language->name }}</label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="players">Players</label>
            @foreach($players as $player)
                <div class="form-check">
                    <input type="checkbox" name="players[]" value="{{ $player->id }}" class="form-check-input" id="player{{ $player->id }}" {{ in_array($player->id, $game->players->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="player{{ $player->id }}">{{ $player->name }}</label>
                </div>
            @endforeach
        </div>
        
        <button type="submit" class="btn btn-primary">Update Game</button>
    </form>
</div>
@endsection