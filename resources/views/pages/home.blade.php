@extends('layouts.app')

@section('title', 'Home')

@section('content')

<script src="{{ asset('js/home/home.js') }}" defer></script>

<section id="home">
    <div id="top-sellers-container">
        @include('partials.top-sellers-chunk', ['topSellersChunk' => $topSellersChunks[0], 'chunkIndex' => 0])
    </div>

    <div class="pagination-controls">
        @foreach ($topSellersChunks as $chunkIndex => $topSellersChunk)
            <button class="pagination-btn" onclick="loadChunk({{ $chunkIndex }})">{{ $chunkIndex + 1 }}</button>
        @endforeach
    </div>
</section>

@endsection