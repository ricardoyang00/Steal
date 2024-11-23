@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <section id="about">
        <h1>About Us</h1>
        @if($abouts->isNotEmpty())
            <p>{{ $abouts->first()->content }}</p>
            <h2>Project Members</h2>
            <ul>
                @foreach($abouts->slice(1) as $about)
                    <li>{{ $about->content }}</li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection