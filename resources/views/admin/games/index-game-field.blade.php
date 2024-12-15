@extends('layouts.app')

@section('title', 'Index Game Fields')

@section('content')

<div class="game-fields">
    <!-- Create New Game Field Form -->
    <div class="create-game-field">
        <h2>Create New Game Field</h2>
        <form action="{{ route('admin.storeGameField') }}" method="POST">
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
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

    <div class="game-fields-lists">
        <!-- List of Categories -->
        <div class="game-categories">
            <h2>Categories</h2>
            <ul>
                @foreach($categories as $category)
                    <li>
                        {{ $category->name }}
                        <div class="action-buttons">
                            <a href="{{ route('admin.editGameField', ['type' => 'category', 'id' => $category->id]) }}" class="edit-button">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <form action="{{ route('admin.destroyGameField', ['type' => 'category', 'id' => $category->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">
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
            <h2>Platforms</h2>
            <ul>
                @foreach($platforms as $platform)
                    <li>
                        {{ $platform->name }}
                        <div class="action-buttons">
                            <a href="{{ route('admin.editGameField', ['type' => 'platform', 'id' => $platform->id]) }}" class="edit-button">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <form action="{{ route('admin.destroyGameField', ['type' => 'platform', 'id' => $platform->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">
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
            <h2>Languages</h2>
            <ul>
                @foreach($languages as $language)
                    <li>
                        {{ $language->name }}
                        <div class="action-buttons">
                            <a href="{{ route('admin.editGameField', ['type' => 'language', 'id' => $language->id]) }}" class="edit-button">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <form action="{{ route('admin.destroyGameField', ['type' => 'language', 'id' => $language->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">
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