@extends('layouts.app')

@section('title', 'Index Game Fields')

@section('content')
<div class="container">
    <h1>Game Fields</h1>

    <!-- Create New Game Field Form -->
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
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>

    <!-- List of Categories -->
    <h2>Categories</h2>
    <ul>
        @foreach($categories as $category)
            <li>
                {{ $category->name }}
                <a href="{{ route('admin.editGameField', ['type' => 'category', 'id' => $category->id]) }}">Edit</a>
                <form action="{{ route('admin.destroyGameField', ['type' => 'category', 'id' => $category->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- List of Platforms -->
    <h2>Platforms</h2>
    <ul>
        @foreach($platforms as $platform)
            <li>
                {{ $platform->name }}
                <a href="{{ route('admin.editGameField', ['type' => 'platform', 'id' => $platform->id]) }}">Edit</a>
                <form action="{{ route('admin.destroyGameField', ['type' => 'platform', 'id' => $platform->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- List of Languages -->
    <h2>Languages</h2>
    <ul>
        @foreach($languages as $language)
            <li>
                {{ $language->name }}
                <a href="{{ route('admin.editGameField', ['type' => 'language', 'id' => $language->id]) }}">Edit</a>
                <form action="{{ route('admin.destroyGameField', ['type' => 'language', 'id' => $language->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection