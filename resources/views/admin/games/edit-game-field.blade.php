@extends('layouts.app')

@section('title', 'Edit ' . ucfirst($type))

@section('content')
<div class="container">
    <h1>Edit {{ ucfirst($type) }}</h1>
    <form action="{{ route('admin.updateGameField', ['type' => $type, 'id' => $entry->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $entry->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection