@extends('layouts.app')

@section('title', 'Channel Stats')

@section('content')
{{-- Terms of Use --}}
<x-breadcrumb :breadcrumbs="config('breadcrumbs.terms')" />

<x-faq-schema :faqs="config('faq.terms-of-use')" />

<section class="page-content">
  <h1>Terms of Use</h1>
  <p>By using YYTuber, you agree not to misuse the service. This platform is for informational and educational purposes only.</p>
  <p>We are not affiliated with YouTube or Google.</p>
</section>

<x-faqs :faqs="config('faq.terms-of-use')" />
@endsection
