<h2 class="text-xl font-semibold">{{ $title }}</h2>
<p>Channel ID: {{ $channel_id }}</p>
<p>Subscribers: {{ number_format($subscribers) }}</p>
<p>Views: {{ number_format($views) }}</p>
<p>Watch Hours (approx): {{ $watchHours }}</p>
<p>Country: {{ $country }}</p>
<p>Videos: {{ $video_count }}</p>
<p>Created: {{ \Carbon\Carbon::parse($created_at)->toFormattedDateString() }}</p>

@if($eligible)
  <p class="text-green-600 font-semibold mt-2">✅ Eligible for monetization!</p>
@else
  <p class="text-red-600 font-semibold mt-2">❌ Not eligible yet.</p>
@endif

<p>Verified: {!! $is_verified ? '<span class="text-green-600">Yes</span>' : '<span class="text-red-600">No</span>' !!}</p>
<p>Join Button Available: {!! $has_join_button ? '<span class="text-green-600">Yes</span>' : '<span class="text-red-600">No</span>' !!}</p>

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
