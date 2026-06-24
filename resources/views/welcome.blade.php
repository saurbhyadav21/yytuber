{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>YouTube Monetization Checker</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 py-10">

<div class="max-w-4xl mx-auto bg-white p-8 shadow rounded">
  <h1 class="text-2xl font-bold mb-4">YouTube Monetization Checker</h1>

  @if(session('error'))
    <div class="text-red-600 mb-4">{{ session('error') }}</div>
  @endif

  <form id="monetizationForm">
    @csrf
    <input type="text" name="channel_url" id="channel_url"
           placeholder="Enter YouTube Channel URL or ID"
           class="w-full border p-2 rounded mb-4" required>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Check</button>
</form>
  <!-- Loader (Hidden by default) -->
<div id="loader" class="fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center hidden z-50">
  <svg class="animate-spin h-10 w-10 text-blue-600" viewBox="0 0 24 24">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
  </svg>
</div>

<div id="result" class="mt-6"></div>


  @isset($title)
    <div class="mt-6">
      <h2 class="text-xl font-semibold">{{ $title }}</h2>
      <p>Channel ID: {{ $channel_id }}</p>
      <p>Subscribers: {{ number_format($subscribers) }}</p>
      <p>Views: {{ number_format($views) }}</p>
      <p>Watch Hours (approx): {{ $watchHours }}</p>
      <p>Country: {{ $country }}</p>
      <p>Videos: {{ $video_count }}</p>
      <p>Created: {{ \Carbon\Carbon::parse($created_at)->toFormattedDateString() }}</p>

      @if($eligible)
        <p class="text-green-600 font-semibold mt-2">✅ This channel is eligible for monetization!</p>
      @else
        <p class="text-red-600 font-semibold mt-2">❌ Not eligible for monetization yet.</p>
      @endif

      <p class="mt-2">Verified: {!! $is_verified ? '<span class=\"text-green-600\">Yes</span>' : '<span class=\"text-red-600\">No</span>' !!}</p>
      <p>Join Button Available: {!! $has_join_button ? '<span class=\"text-green-600\">Yes</span>' : '<span class=\"text-red-600\">No</span>' !!}</p>

      @if(!empty($topics))
        <div class="mt-4">
          <h3 class="font-bold">Topics:</h3>
          <ul class="list-disc ml-6">
            @foreach($topics as $topic)
              <li><a href="{{ $topic }}" target="_blank" class="text-blue-600">{{ $topic }}</a></li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="mt-4">
        <h3 class="font-bold mb-2">Channel Profile Pictures:</h3>
        <div class="grid grid-cols-3 gap-4">
          @foreach($profile_pictures as $size => $url)
            <div>
              <img src="{{ $url }}" alt="{{ $size }}" class="w-full rounded">
              <p class="text-sm text-center mt-1">{{ $size }}</p>
            </div>
          @endforeach
        </div>
      </div>

      <div class="mt-6">
        <h3 class="font-bold mb-2">Channel Cover Art Images:</h3>
        <div class="grid grid-cols-2 gap-4">
          @foreach($cover_images as $size => $url)
            <div>
              <img src="{{ $url }}" alt="{{ $size }}" class="w-full">
              <p class="text-sm text-center mt-1">{{ $size }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endisset
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('monetizationForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const loader = document.getElementById('loader');
    const result = document.getElementById('result');
    loader.classList.remove('hidden');
    result.innerHTML = '';

    const channelUrl = document.getElementById('channel_url').value;
    const encryptedData = btoa(channelUrl); // Basic base64 "encryption" - you can switch to AES

    axios.post("{{ route('check.monetization') }}", {
        encrypted: encryptedData
    }, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        loader.classList.add('hidden');
        const stats = response.data.stats;

        // Display the stats in the result section
        document.getElementById('result').innerHTML = `
            <h2 class="text-xl font-semibold">${stats.title}</h2>
            <p>Subscribers: ${stats.subscribers}</p>
            <p>Views: ${stats.views}</p>
            <p>Watch Hours: ${stats.watchHours}</p>
            <p>Eligible: ${stats.eligible ? 'Yes' : 'No'}</p>
        `;

        // Check if there's a redirect URL and redirect the page
        if (response.data.redirectUrl) {
            window.location.href = response.data.redirectUrl; // Redirect to the provided URL
        }
    })
    .catch(error => {
        loader.classList.add('hidden');
        alert(error.response?.data?.message || 'Something went wrong!');
    });
});

</script>
</body>
</html> --}}



@extends('layouts.app')

@section('title', 'Channel Stats')

@section('content')
 <x-faqs :faqs="config('faq.track-channel')" />
<section class="hero">
 <h1>Track Any YouTube Channel</h1>
 <p>Statistics | Growth | Income | Views | Subscribers | Monetization</p>
 <form id="monetizationForm">
   @csrf
   <input type="text" placeholder="Enter YouTube Channel ID or URL" name="channel_url" id="channel_url"/>
   <button type="submit"><i class="bi bi-search"></i> Check Now</button>
 </form>
 
  
   <!-- Updated Loader -->
   

   
</section>
<div id="result" class="mt-6"></div>

{{-- <section class="hero">

 <h1>Top 10 YouTube Channels</h1>
 <div class="table-responsive">
   <table class="table channel-table text-white">
     <thead>
       <tr>
         <th>#</th>
         <th>Channel Name</th>
         <th>Subscribers</th>
         <th>Total Views</th>
       </tr>
     </thead>
     <tbody>
       <tr><td>1</td><td>T-Series</td><td>265M+</td><td>245B+</td></tr>
       <tr><td>2</td><td>MrBeast</td><td>245M+</td><td>45B+</td></tr>
       <tr><td>3</td><td>Cocomelon</td><td>175M+</td><td>180B+</td></tr>
       <tr><td>4</td><td>SET India</td><td>170M+</td><td>160B+</td></tr>
       <tr><td>5</td><td>Kids Diana Show</td><td>120M+</td><td>100B+</td></tr>
       <tr><td>6</td><td>Like Nastya</td><td>115M+</td><td>90B+</td></tr>
       <tr><td>7</td><td>Vlad and Niki</td><td>110M+</td><td>95B+</td></tr>
       <tr><td>8</td><td>Zee Music Company</td><td>105M+</td><td>75B+</td></tr>
       <tr><td>9</td><td>WWE</td><td>102M+</td><td>80B+</td></tr>
       <tr><td>10</td><td>BLACKPINK</td><td>90M+</td><td>40B+</td></tr>
     </tbody>
   </table>
 </div>
</section>

<section class="stats-preview">
 <div class="stat-card"><i class="bi bi-tv-fill"></i> 10M+ Channels Tracked</div>
 <div class="stat-card"><i class="bi bi-graph-up"></i> Real-Time Stats</div>
 <div class="stat-card"><i class="bi bi-cash-stack"></i> Monetization Estimator</div>
</section> --}}

 
@endsection
