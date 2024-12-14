@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <section id="contacts">
        <h1>Contact Us</h1>
        <p>If you have any questions or need further information, please feel free to reach out to us at:</p>
        <ul>
            @foreach($contacts as $contact)
                <li>
                    <strong>{{ $contact->contact }}</strong>
                </li>
            @endforeach
        </ul>
    </section>
@endsection