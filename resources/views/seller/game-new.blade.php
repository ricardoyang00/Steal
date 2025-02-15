@extends('layouts.app')

@section('title', 'New Game')

@section('content')

<script src="{{ asset('js/seller/new-game.js') }}" defer></script>

<div class="new-game-page">
    <h1><a href="{{ url('seller/products') }}"><i class="fa-solid fa-chevron-left" style="color: white;"></i></a>New Game</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="game-form" action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <!-- description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <!-- price -->
        <div class="form-group">
            <label for="price">Price (€)</label>
            <input type="number" name="price" class="form-control" step="0.01" max="9999.99" required>
        </div>
        <!-- release date -->
        <div class="form-group">
            <label for="release_date">Release Date</label>
            <input type="date" name="release_date" class="form-control" max="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
            <input type="checkbox" class="form-check-input" id="pre_release" name="pre_release">
            <label class="form-check-label" for="pre_release">❗️ Pre-Release</label>
        </div>
        <!-- age restriction -->
        <div class="form-group">
            <label for="age_id">Age Restriction</label>
            @foreach($ages as $age)
                <div class="form-check">
                    <input type="radio" name="age_id" value="{{ $age->id }}" class="form-check-input" id="age{{ $age->id }}" required>
                    <label class="form-check-label" for="age{{ $age->id }}">
                        <img src="{{ asset($age->image_path) }}" alt="{{ $age->name }}">
                        {{ $age->name }}
                        <a href="{{ url('/age/' . $age->id) }}" class="btn-info" target="_blank"><i class="fa-solid fa-circle-info" style="color: white;"></i></a>
                    </label>
                </div>
            @endforeach
        </div>
        <!-- categories -->
        <div class="form-group">
            <label for="categories">Categories</label>
            @foreach($categories as $category)
                <div class="form-check">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-check-input" id="category{{ $category->id }}">
                    <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>
        <!-- platforms -->
        <div class="form-group">
            <label for="platforms">Platforms</label>
            @foreach($platforms as $platform)
                <div class="form-check">
                    <input type="checkbox" name="platforms[]" value="{{ $platform->id }}" class="form-check-input" id="platform{{ $platform->id }}">
                    <label class="form-check-label" for="platform{{ $platform->id }}">{{ $platform->name }}</label>
                </div>
            @endforeach
        </div>
        <!-- languages -->
        <div class="form-group">
            <label for="languages">Languages</label>
            @foreach($languages as $language)
                <div class="form-check">
                    <input type="checkbox" name="languages[]" value="{{ $language->id }}" class="form-check-input" id="language{{ $language->id }}">
                    <label class="form-check-label" for="language{{ $language->id }}">{{ $language->name }}</label>
                </div>
            @endforeach
        </div>
        <!-- players -->
        <div class="form-group">
            <label for="players">Players</label>
            @foreach($players as $player)
                <div class="form-check">
                    <input type="checkbox" name="players[]" value="{{ $player->id }}" class="form-check-input" id="player{{ $player->id }}">
                    <label class="form-check-label" for="player{{ $player->id }}">{{ $player->name }}</label>
                </div>
            @endforeach
        </div>
        <!-- large thumbnails -->
        <div class="form-group">
            <label for="thumbnail_large_path">Thumbnail Large
                <span class="hint-icon" data-tooltip="The large thumbnail is the main image that will be shown on the home page and in search or browse results.">?</span>
            </label>
            <input type="file" name="thumbnail_large_path" class="form-control-file" required>
            <small class="image-hint">Recommended aspect ratio: 16:9 (1920x1080). Max size 2MB.</small>
            <img id="thumbnail_large_preview" src="#" alt="Thumbnail Large Preview" style="display: none;"/>
        </div>
        <!-- small thumbnails -->
        <div class="form-group">
            <label for="thumbnail_small_path">Thumbnail Small
                <span class="hint-icon" data-tooltip="The small thumbnail is the one that will be shown as a card in the user's shopping cart or wish list.">?</span>
            </label>
            <input type="file" name="thumbnail_small_path" class="form-control-file" required>
            <small class="image-hint">Recommended size: 270x400. Max size 2MB.</small>
            <img id="thumbnail_small_preview" src="#" alt="Thumbnail Small Preview" style="display: none;"/>
        </div>
        <!-- additional images -->
        <div class="form-group">
            <label for="additional_images">Additional Large Images
                <span class="hint-icon" data-tooltip="The additional images provide more details and will be shown on the product's page.">?</span>
            </label>
            <input type="file" name="additional_images[]" class="form-control-file" multiple>
            <small class="image-hint">Recommended aspect ratio: 16:9. You can upload multiple images. Max size per image 2MB.</small>
            <div id="additional_images_preview" class="d-flex flex-wrap"></div>
        </div>

        
        <button type="submit" class="create-game-btn">Create Game</button>
    </form>
</div>
@endsection