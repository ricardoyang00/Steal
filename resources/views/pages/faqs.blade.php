@extends('layouts.app')

@section('title', 'FAQs')

@section('content')
    <section id="faqs">
        <h1>Frequently Asked Questions</h1>
        <ul>
            @foreach($faqs as $faq)
                <li>
                    <strong>{{ $faq->question }}</strong>
                    <p>{{ $faq->answer }}</p>
                </li>
            @endforeach
        </ul>
    </section>
@endsection