@extends('layouts.app')

@section('title', 'Manage CDKs for ' . $game->name)

@section('content')
<div class="container mt-5">
    <h1>
        <a href=" {{ url('seller/products') }} ">
            <i class="fa-solid fa-chevron-left" style="color: white;"></i>
        </a>Manage CDKs for {{ $game->name }}
    </h1>

    <div class="mb-3">
        <p><strong>Available CDKs: </strong>{{ $totalAvailable }}</p>
        <form action="{{ route('games.cdks.add', $game->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="quantity">Add CDKs</label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Add CDKs</button>
        </form>
    </div>

    <div class="mb-3">
        <form action="{{ route('games.cdks', $game->id) }}" method="GET">
            <label for="filter">Sort by:</label>
            <select id="filter" name="filter" class="form-control" onchange="this.form.submit()">
                <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>All</option>
                <option value="available" {{ $filter === 'available' ? 'selected' : '' }}>Available</option>
                <option value="sold" {{ $filter === 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
        </form>
    </div>

    <table class="table table-bordered" style="color: white;">
        <thead>
            <tr>
                <th>State</th>
                <th>CDK</th>
            </tr>
        </thead>
        <tbody id="cdk-list">
            @foreach ($cdks as $cdk)
                <tr class="cdk-item {{ $cdk->isSold() ? 'sold' : 'available' }}">
                    <td style="color: {{ $cdk->isSold() ? 'red' : 'green' }}">{{ $cdk->isSold() ? 'Sold' : 'Available' }}</td>
                    <td>{{ $cdk->code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination-links">
        {{ $cdks->links() }}
    </div>
</div>
@endsection