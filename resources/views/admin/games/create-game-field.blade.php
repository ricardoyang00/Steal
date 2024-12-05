@extends('layouts.app')

@section('title', 'Create Game Field')

@section('content')

<div class="container">
    <h1>Create New Game Field</h1>
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
</div>

@endsection