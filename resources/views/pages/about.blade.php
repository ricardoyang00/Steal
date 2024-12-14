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
            <p> The project was led by Professor Inês Teixeira.</p>
        @endif

        <h2>Main Features</h2>
        <p>
            STEAL! offers a powerful search and filtering system that helps users easily find the games they want. You can manage your selections with a shopping cart and enjoy a personalized profile that keeps track of your purchase history and wishlist. If you're unsure what to play next, we also provide tailored game recommendations based on your preferences. Additionally, users can leave reviews for games they've purchased to help others make informed decisions.
        </p>



        <p>
            We've partnered with multiple game companies to list their titles directly on our platform, offering a wide and diverse selection of games. Users can sign in using their STEAL! account or log in via Google for a seamless authentication process.
        </p>

        <p>
            Authenticated users with games on their wishlist will receive real-time notifications about discounts and special offers, so they never miss a great deal. Our platform also supports multiple payment methods, allowing users from around the world to make purchases in their preferred way for a more convenient shopping experience.
        </p>

        <p>
            As a token of appreciation, we reward our users with S coins, which can be used to get discounts on future game purchases. When you buy a game, you earn a percentage of your payment back in S coins. These coins can be applied to reduce the price of your next game, making your shopping experience more rewarding and cost-effective.
        </p>

        <p>
            Enjoy a top-rated, minimalist design that makes browsing easy and provides unbeatable deals, ensuring your shopping experience is smooth and enjoyable.
        </p>

        <p>
            Our dedicated staff is actively involved in managing the site and monitoring user activity. If any suspicious behavior or inappropriate content is detected, whether in reviews or elsewhere, our team takes swift action to maintain a safe and healthy community. We also offer a help section where users can reach out to staff or administrators for assistance or to report any concerns. Any doubts or questions, feel free to <a href="{{ url('/contact') }}">contact us</a>.
        </p>

    </section>
@endsection