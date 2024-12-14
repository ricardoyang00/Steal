@extends('layouts.app')

@section('title', 'FAQs')

@section('content')
    <section id="faqs">
        <h1>Frequently Asked Questions</h1>
        <ul>
            @foreach($faqs as $faq)
                <li>
                    <h2>{{ $faq->question }}</h2>
                    <p>{{ $faq->answer }}</p>
                </li>
            @endforeach
        </ul>

        <p>If you have any other questions, please feel free to <a href="{{ url('/contact') }}">contact us</a>.</p>
    </section>
@endsection