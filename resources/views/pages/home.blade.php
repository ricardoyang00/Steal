@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section id="home">
        <article>
            <h1>Hello World</h1>
            <button onclick="window.location.href = '{{ route('shopping_cart') }}';">Shopping Cart Button</button>
            <p>This is a simple example page.</p>
            <p><strong>IN CONTRUCTION...</strong></p>
            <p><strong>IN CONTRUCTION...</strong></p>
            <p><strong>IN CONTRUCTION...</strong></p>
            <p><strong>IN CONTRUCTION...</strong></p>
            <p><strong>IN CONTRUCTION...</strong></p>
        </article>
    </section>
@endsection