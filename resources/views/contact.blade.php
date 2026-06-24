@extends('layouts.app')

@section('title', 'Channel Stats')
{{-- Contact --}}
<x-breadcrumb :breadcrumbs="config('breadcrumbs.contact')" />

<x-faq-schema :faqs="config('faq.contact')" />
@section('content')
<div class="container">
<section class="page-content">
  <h1>Contact Us</h1>
  <p>If you have any questions, feel free to reach out:</p>
  <ul>
    <li>Email: support@YYTuber.com</li>
    <li>Phone: +91-9876543210</li>
    <li>Address: Mumbai, India</li>
  </ul>
</section>
</div>
<x-faqs :faqs="config('faq.contact')" />
@endsection
