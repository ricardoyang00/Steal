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
                            <form action="{{ route('admin.destroyGameField', ['type' => 'category', 'id' => $category->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button"><i class="fas fa-trash-alt"></i> Delete</button>
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
                        <span class="field-name">{{ $platform->name }}</span>
                        <form action="{{ route('admin.updateGameField', ['type' => 'platform', 'id' => $platform->id]) }}" method="POST" class="edit-form" style="display: none;">
                            @csrf
                            @method('POST')
                            <input type="text" class="form-control" name="name" value="{{ $platform->name }}" required maxlength="20" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
                            <button type="submit" class="confirm-button">Confirm</button>
                            <button type="button" class="cancel-button">Cancel</button>
                        </form>
                        <div class="action-buttons">
                            <button class="edit-button"><i class="fas fa-pencil-alt"></i> Edit</button>
                            <form action="{{ route('admin.destroyGameField', ['type' => 'platform', 'id' => $platform->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button"><i class="fas fa-trash-alt"></i> Delete</button>
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
                            <form action="{{ route('admin.destroyGameField', ['type' => 'language', 'id' => $language->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button"><i class="fas fa-trash-alt"></i> Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>    
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-button');
    const cancelButtons = document.querySelectorAll('.cancel-button');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const li = this.closest('li');
            li.classList.add('editing');
            li.querySelector('.field-name').style.display = 'none';
            li.querySelector('.edit-form').style.display = 'flex';
            li.querySelector('.action-buttons').style.display = 'none';
        });
    });

    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const li = this.closest('li');
            li.classList.remove('editing');
            li.querySelector('.field-name').style.display = 'inline';
            li.querySelector('.edit-form').style.display = 'none';
            li.querySelector('.action-buttons').style.display = 'flex';
        });
    });
});
</script>

@endsection