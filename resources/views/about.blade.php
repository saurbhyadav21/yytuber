@extends('layouts.app')

@section('title', 'Channel Stats')

@section('content')

<x-faq-schema :faqs="config('faq.about')" />
<section class="page-content">
  <h1>About Us</h1>
  <p>YYTuber is a platform designed to help creators and businesses analyze YouTube data and estimate monetization eligibility with ease.</p>
  <p>We believe in empowering YouTubers with transparent, useful, and real-time insights.</p>
</section>

<x-faqs :faqs="config('faq.about')" />

@endsection
