@extends('layouts.app')

@section('title', 'Index Game Fields')

@section('content')
<div class="container">
    <h1>Game Fields</h1>

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