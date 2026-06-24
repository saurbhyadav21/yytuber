@extends('layouts.app')

@section('title', 'Channel Stats')

@section('content')
<x-faq-schema :faqs="config('faq.privacy-policy')" />

<div class="container">
  <section class="page-content">
    <h1>Privacy Policy</h1>
    <p>We respect your privacy. We do not collect personal information unless explicitly provided by you.</p>
    <p>Any data analyzed using our platform is processed temporarily and securely.</p>
  </section>
</div>
<x-faqs :faqs="config('faq.privacy-policy')" />
@endsection
