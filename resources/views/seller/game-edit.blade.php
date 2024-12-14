@extends('layouts.app')

@section('title', 'Edit Game')

<script src="{{ asset('js/seller/edit-game.js') }}" defer></script>

@section('content')
<div class="container mt-5">
    <h1><a href="{{ url('seller/products') }}"><i class="fa-solid fa-chevron-left" style="color: white;"></i></a>Edit Game</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $game->name }}" required>
        </div>
        <!-- description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $game->description }}</textarea>
        </div>
        <!-- price -->
        <div class="form-group">
            <label for="price">Price (€)</label>
            <input type="number" name="price" class="form-control" value="{{ $game->price }}" step="0.01" required>
        </div>
        <!-- release date -->
        <div class="form-group">
            <label for="release_date">Release Date</label>
            <input type="date" name="release_date" class="form-control" value="{{ $game->release_date }}" required>
        </div>
        <!-- age restriction -->
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
        <!-- categories -->
        <div class="form-group">
            <label for="categories">Categories</label>
            @foreach($categories as $category)
                <div class="form-check">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-check-input" id="category{{ $category->id }}" {{ in_array($category->id, $game->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>
        <!-- platforms -->
        <div class="form-group">
            <label for="platforms">Platforms</label>
            @foreach($platforms as $platform)
                <div class="form-check">
                    <input type="checkbox" name="platforms[]" value="{{ $platform->id }}" class="form-check-input" id="platform{{ $platform->id }}" {{ in_array($platform->id, $game->platforms->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="platform{{ $platform->id }}">{{ $platform->name }}</label>
                </div>
            @endforeach
        </div>
        <!-- languages -->
        <div class="form-group">
            <label for="languages">Languages</label>
            @foreach($languages as $language)
                <div class="form-check">
                    <input type="checkbox" name="languages[]" value="{{ $language->id }}" class="form-check-input" id="language{{ $language->id }}" {{ in_array($language->id, $game->languages->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="language{{ $language->id }}">{{ $language->name }}</label>
                </div>
            @endforeach
        </div>
        <!-- players -->
        <div class="form-group">
            <label for="players">Players</label>
            @foreach($players as $player)
                <div class="form-check">
                    <input type="checkbox" name="players[]" value="{{ $player->id }}" class="form-check-input" id="player{{ $player->id }}" {{ in_array($player->id, $game->players->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="player{{ $player->id }}">{{ $player->name }}</label>
                </div>
            @endforeach
        </div>
        <!-- large thumbnails -->
        <div class="form-group">
            <label for="thumbnail_large_path">Thumbnail Large (16:9)</label>
            <input type="file" name="thumbnail_large_path" class="form-control-file" id="thumbnail_large_path">
            <small class="form-text text-muted">Recommended aspect ratio: 16:9</small>
            <img src="{{ asset($game->getThumbnailLargePath()) }}" alt="Thumbnail Large" id="thumbnail_large_preview">
        </div>
        <!-- small thumbnails -->
        <div class="form-group">
            <label for="thumbnail_small_path">Thumbnail Small (270x400)</label>
            <input type="file" name="thumbnail_small_path" class="form-control-file" id="thumbnail_small_path">
            <small class="form-text text-muted">Recommended size: 270x400</small>
            <img src="{{ asset($game->getThumbnailSmallPath()) }}" alt="Thumbnail Small" id="thumbnail_small_preview">
        </div>
        <!-- additional images -->
        <div class="form-group">
            <label for="additional_images">Additional Large Images (16:9)</label>
            <input type="file" name="additional_images[]" class="form-control-file" id="additional_images" multiple>
            <small class="form-text text-muted">Recommended aspect ratio: 16:9. You can upload multiple images.</small>
            <div class="d-flex flex-wrap" id="additional_images_preview">
                @foreach($game->images as $media)
                    <div class="position-relative m-2">
                        <img src="{{ asset($media->path) }}" alt="Additional Image" style="width: 320px; height: 180px;">
                    </div>
                @endforeach
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Game</button>
    </form>
</div>
@endsection