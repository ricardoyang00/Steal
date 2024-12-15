@extends('layouts.app')

@section('title', 'Index Game Fields')

@section('content')

<script src="{{ asset('js/admin/manage-game-fields.js') }}" defer></script>
<script src="{{ asset('js/common/confirmation-modal.js') }}" defer></script>

<div class="game-fields">
    <!-- Create New Game Field Form -->
    <div class="create-game-field">
        <h2 class="title">Create New Game Field</h2>
        <form action="{{ route('admin.storeGameField') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="category">Category</option>
                    <option value="platform">Platform</option>
                    <option value="language">Language</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required maxlength="20" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
            </div>
            <div class="form-group" id="platform-logo-group" style="display: none;">
                <label for="logo">Platform Logo (SVG)</label>
                <input type="file" class="form-control" id="logo" name="logo" accept=".svg">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
    
    <div class="game-fields-lists">
        <!-- List of Categories -->
        <div class="game-categories">
            <h2 class="title">Categories</h2>
            <ul>
                @foreach($categories as $category)
                    <li>
                        @include('partials.common.confirmation-modal')
                        <span class="field-name">{{ $category->name }}</span>
                        <form action="{{ route('admin.updateGameField', ['type' => 'category', 'id' => $category->id]) }}" method="POST" class="edit-form" style="display: none;">
                            @csrf
                            @method('POST')
                            <input type="text" class="form-control" name="name" value="{{ $category->name }}" required maxlength="20" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
                            <button type="submit" class="confirm-button">Confirm</button>
                            <button type="button" class="cancel-button">Cancel</button>
                        </form>
                        <div class="action-buttons">
                            <button class="edit-button"><i class="fas fa-pencil-alt"></i> Edit</button>
                            <form action="{{ route('admin.destroyGameField', ['type' => 'category', 'id' => $category->id]) }}" method="POST" style="display:inline;" id="delete-category-form-{{ $category->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="confirmation-btn delete-button"
                                    data-title="Delete Category"
                                    data-message="Are you sure you want to delete {{ $category->name }} ?"
                                    data-form-id="delete-category-form-{{ $category->id }}">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- List of Platforms -->
        <div class="game-platforms">
            <h2 class="title">Platforms</h2>
            <ul>
                @foreach($platforms as $platform)
                    <li>
                        @include('partials.common.confirmation-modal')
                        <div class="label">
                            <img src="{{ asset('images/platform_logos/' . $platform->id . '.svg') }}" alt="{{ $platform->name }} logo" class="img-fluid" style="width: 20px; height: 30px;">
                            <span class="field-name">{{ $platform->name }}</span>
                        </div>
                        <form action="{{ route('admin.updateGameField', ['type' => 'platform', 'id' => $platform->id]) }}" method="POST" class="edit-form" style="display: none;">
                            @csrf
                            @method('POST')
                            <input type="text" class="form-control" name="name" value="{{ $platform->name }}" required maxlength="20" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
                            <button type="submit" class="confirm-button">Confirm</button>
                            <button type="button" class="cancel-button">Cancel</button>
                        </form>
                        <div class="action-buttons">
                            <button class="edit-button"><i class="fas fa-pencil-alt"></i> Edit</button>
                            <form action="{{ route('admin.destroyGameField', ['type' => 'platform', 'id' => $platform->id]) }}" method="POST" style="display:inline;" id="delete-platform-form-{{ $platform->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="confirmation-btn delete-button"
                                    data-title="Delete Platform"
                                    data-message="Are you sure you want to delete {{ $platform->name }} ?"
                                    data-form-id="delete-platform-form-{{ $platform->id }}">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- List of Languages -->
        <div class="game-languages">
            <h2 class="title">Languages</h2>
            <ul>
                @foreach($languages as $language)
                    <li>
                        @include('partials.common.confirmation-modal')
                        <span class="field-name">{{ $language->name }}</span>
                        <form action="{{ route('admin.updateGameField', ['type' => 'language', 'id' => $language->id]) }}" method="POST" class="edit-form" style="display: none;">
                            @csrf
                            @method('POST')
                            <input type="text" class="form-control" name="name" value="{{ $language->name }}" required maxlength="20" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
                            <button type="submit" class="confirm-button">Confirm</button>
                            <button type="button" class="cancel-button">Cancel</button>
                        </form>
                        <div class="action-buttons">
                            <button class="edit-button"><i class="fas fa-pencil-alt"></i> Edit</button>
                            <form action="{{ route('admin.destroyGameField', ['type' => 'language', 'id' => $language->id]) }}" method="POST" style="display:inline;" id="delete-language-form-{{ $language->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="confirmation-btn delete-button"
                                    data-title="Delete Language"
                                    data-message="Are you sure you want to delete {{ $language->name }} ?"
                                    data-form-id="delete-language-form-{{ $language->id }}">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>    
        </div>
    </div>
</div>

@endsection