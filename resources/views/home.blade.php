@extends('layouts.app')

@section('title', 'Channel Stats')

@section('content')
<!-- Font Awesome (if not already included in layout) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<x-breadcrumb-schema :breadcrumbs="config('breadcrumbs.home')" />

<div class="container py-5">
    <h1 class="text-center mb-5 fw-bold" style="color: #fd0d0d;">Best YouTube Tutorials and 1</h1>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <x-faq-schema :faqs="config('faq.home')" />

        @php
            $tools = [
                ['title' => 'YouTube Monetization Checker', 'desc' => 'Check if a YouTube channel or video is monetized.', 'icon' => 'fa-dollar-sign', 'url' => '/monetization-checker', 'color' => 'success'],
                ['title' => 'YouTube Channel ID Finder', 'desc' => 'Find any channel\'s ID using the YouTube Data API.', 'icon' => 'fa-id-badge', 'url' => '/channel-id-finder', 'color' => 'info'],
                ['title' => 'YouTube Data Viewer', 'desc' => 'Reveal metadata like upload time, tags, and monetization.', 'icon' => 'fa-database', 'url' => '/data-viewer', 'color' => 'primary'],
                ['title' => 'YouTube Profile Picture & Image Downloader', 'desc' => 'Download channel pictures, banners, and thumbnails in HD.', 'icon' => 'fa-image', 'url' => '/image-downloader', 'color' => 'danger'],
                ['title' => 'YouTube Tag Extractor', 'desc' => 'Extract video tags and keywords for SEO and research.', 'icon' => 'fa-tags', 'url' => '/tag-extractor', 'color' => 'warning'],
                ['title' => 'YouTube Shadowban Checker', 'desc' => 'Check if a channel is shadowbanned and its visibility status.', 'icon' => 'fa-user-secret', 'url' => '/shadowban-checker', 'color' => 'secondary'],
                ['title' => 'YouTube Money Calculator', 'desc' => 'Estimate earnings based on video and channel metrics.', 'icon' => 'fa-calculator', 'url' => '/money-calculator', 'color' => 'success'],
            ];
        @endphp

        @foreach ($tools as $tool)
            <div class="col">
                <div class="card shadow h-100 border-0">
                    <div class="card-body">
                        <h5 class="card-title text-{{ $tool['color'] }}">
                            <i class="fas {{ $tool['icon'] }} me-2"></i> {{ $tool['title'] }}
                        </h5>
                        <p class="card-text">{{ $tool['desc'] }}</p>
                        <a href="{{ url($tool['url']) }}" class="btn btn-outline-{{ $tool['color'] }} btn-sm">
                            Learn More <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <!-- Topics Section -->
    <section class="hero mt-5" style="padding: 1rem 1rem;">
        <h2 class="text-center mb-2">Explore Topicxsxxs</h2>
        <p class="text-center text-muted" style="color: #fff !important;">Tips, tutorials, and how-to guides</p>
        @php
            $tags = [
                'YouTube','Amazon','Facebook','Gmail','Wordle','Google','Google Translate',
                'Translate','Weather','ChatGPT','WhatsApp','Instagram','Twitter','TikTok',
                'Netflix','News','Maps','LinkedIn','Zoom','Pinterest','Spotify','Walmart',
                'Craigslist','eBay','CNN','Reddit','Calculator','Apple','Hotmail','Speed Test'
            ];
        @endphp

        <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
            @foreach ($tags as $tag)
                <a href="{{ url('/search?q=' . urlencode($tag)) }}" class="badge bg-light text-dark border px-3 py-2 text-decoration-none" style="transition: all 0.3s ease;">
                    #{{ $tag }}
                </a>
            @endforeach
        </div>
    </section>

    <x-faqs :faqs="config('faq.home')" />
</div>

<style>
    .card:hover {
        transform: translateY(-4px);
        transition: 0.3s ease-in-out;
    }
</style>
@endsection
