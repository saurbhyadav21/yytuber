 @extends('layouts.app')

 @section('title', 'Channel Stats')
 
 @section('content')
  
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
<section class="hero">
  <h1>Explore Topics</h1>
  <p>Tips, tutorials, and how-to guides</p>
  @php
  $tags = [ 'YouTube',
'Amazon',
'Facebook',
'Gmail',
'Wordle',
'Google',
'Google Translate',
'Translate',
'Weather',
'ChatGPT',
'WhatsApp',
'Instagram',
'Twitter',
'TikTok',
'Netflix',
'News',
'Maps',
'LinkedIn',
'Zoom',
'Pinterest',
'Spotify',
'Walmart',
'Craigslist',
'eBay',
'CNN',
'Reddit',
'Calculator',
'Apple',
'Hotmail',
'Speed Test'];
  @endphp

  <div class="tags">
      @foreach ($tags as $tag)
          <a href="/">{{ '#' . $tag }}</a>
      @endforeach
  </div>
</section>

<section class="container">
  <h1 class="text-center my-4 text-danger">Top 10 YouTube Channels Worldwide</h1>
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
</section>

  
 @endsection
