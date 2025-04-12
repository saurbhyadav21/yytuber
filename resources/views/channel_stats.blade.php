@extends('layouts.app')

@section('title', 'Channel Stats')

@section('content')


  <style>
    * { box-sizing: border-box; }
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #111; color: white; }
    .container { max-width: 1200px; margin: auto; padding: 20px; border-radius: 15px; box-shadow: 0 0 25px #ff0000; background: #1e1e1e; }
    .banner { width: 100%; height: 200px; background-image: url('{{ $data['cover_images']['2120x351'] }}'); background-size: cover; background-position: center; position: relative; border-radius: 15px 15px 0 0; }
    .profile { position: absolute; top: 140px; left: 50px; display: flex; align-items: center; }
    .profile img { width: 100px; height: 100px; border-radius: 50%; border: 4px solid white; }
    .profile-info { margin-left: 3px;
    color: white;
    margin-top: 70px; }
    .profile-info h2 { margin: 0; font-size: 24px; color: red; }
    .stats-grid { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 100px; }
    .stat-box { flex: 1 1 200px; background: #222; padding: 15px; border-radius: 10px; text-align: center; box-shadow: 0 0 15px #ff0000; transition: all 0.3s ease; }
    .stat-box:hover { background: #333; box-shadow: 0 0 20px #ff8c00; transform: scale(1.05); }
    .stat-box h3 { margin: 10px 0 5px; color: #ff0000; }
    .stat-box p { font-size: 20px; font-weight: bold; color: #ff8c00; }
    .daily-performance { margin-top: 40px; }
    .daily-performance h3 { margin-bottom: 20px; color: #ff0000; }
    .daily-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 20px; }
    .day-box { background: #222; border-radius: 10px; padding: 15px; box-shadow: 0 0 10px #ff8c00; text-align: center; }
    .day-box h4 { margin: 0 0 10px; font-size: 16px; color: #ff8c00; }
    .day-box p { margin: 4px 0; font-size: 14px; color: #ff8c00; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; text-align: center; border: 1px solid #444; }
    th { background-color: #333; color: #ff0000; }
    td { background-color: #222; color: #fff; }
    tr:nth-child(even) { background-color: #333; }
    .highlight { color: #ff0000; font-weight: bold; }
    @media (max-width: 600px) {
      .profile { top: 120px; left: 20px; flex-direction: column; align-items: flex-start; }
      .profile-info { margin-left: 0; margin-top: 10px; }
    }
    .pp{    color: white;
      text-decoration: auto;}
      .stats-grid:nth-of-type(3) {
  /* your styles here */
  margin-top: 20px;
}
  </style>
  {{-- <pre>@php
    print_r($data['topics']);
  @endphp</pre> --}}
<div class="container">
  <div class="banner">
    <div class="profile">
      <img src="{{ $data['profile_pictures']['default'] }}" alt="Profile Logo">
      <div class="profile-info">
        <h2>{{ $data['title'] }} - {{ $data['title2'] }}</h2>
        <p>
          @php
              $topics = $data['topics'];
              $formattedTopics = [];
          
              foreach ($topics as $topicUrl) {
                  $topicName = basename($topicUrl); // Get the last part of the URL
                  $formattedTopics[] = '<a class="pp" href="' . $topicUrl . '" target="_blank">' . $topicName . '</a>';
              }
          
              echo implode(' | ', $formattedTopics);
          @endphp
          </p>
          
      </div>
    </div>
  </div>

  <div class="stats-grid">
    <div class="stat-box">
      <h3>Subscribers</h3>
      <p>{{ number_format($data['subscribers']) }}</p>
    </div>
    <div class="stat-box">
      <h3>Total Views</h3>
      <p>{{ number_format($data['views']) }}</p>
    </div>
    <div class="stat-box">
      <h3>Total Videos</h3>
      <p>{{ number_format($data['video_count']) }}</p>
    </div>
    <div class="stat-box">
      <h3>Created On</h3>
      <p>{{ date("d-m-Y", strtotime($data['created_at'])) }}</p>
    </div>
  </div>
  <div class="stats-grid">
    <div class="stat-box">
      <h3>Hourly Earning</h3>
      <p>$3.7K - $59K</p>
    </div>
    <div class="stat-box">
      <h3>Daily Earning</h3>
      <p>$3.7K - $59K</p>
    </div>
    <div class="stat-box">
      <h3>Weekly Earning</h3>
      <p>$3.7K - $59K</p>
    </div>
    <div class="stat-box">
      <h3>Yearly Earning</h3>
      <p>$3.7K - $59K</p>
    </div>
  </div>

  <div class="daily-performance">
    <h3>📈 Daily Performance</h3>
    <div class="daily-grid">
      <div class="day-box">
        <h4>2025-04-06</h4>
        <p>Subscribers: +1K</p>
        <p>Views: 468,576</p>
        <p>Uploads: 1,510</p>
        <p>Earnings: $117 - $1.9K</p>
      </div>
      <div class="day-box">
        <h4>2025-04-07</h4>
        <p>Subscribers: +0</p>
        <p>Views: 381,420</p>
        <p>Uploads: 1,512</p>
        <p>Earnings: $95 - $1.5K</p>
      </div>
    </div>
  </div>

  <table>
    <tr>
      <th>Date</th>
      <th>Subscribers</th>
      <th>Views</th>
      <th>Videos</th>
      <th>Estimated Earnings</th>
    </tr>
    <tr>
      <td>Sun 2025-03-30</td>
      <td class="highlight">--</td>
      <td>2.5M</td>
      <td>320,019</td>
      <td>--</td>
    </tr>
    <tr>
      <td>Mon 2025-03-31</td>
      <td class="highlight">--</td>
      <td>2.5M</td>
      <td>218,898</td>
      <td>$55 - $876</td>
    </tr>
    <tr>
      <td>Tue 2025-04-01</td>
      <td class="highlight">--</td>
      <td>2.5M</td>
      <td>368,331</td>
      <td>$92 - $1.5K</td>
    </tr>
    <tr>
      <td>Wed 2025-04-02</td>
      <td>10K</td>
      <td>2.51M</td>
      <td>1,128,973</td>
      <td>$282 - $4.5K</td>
    </tr>
    <tr>
      <td>Thu 2025-04-03</td>
      <td class="highlight">--</td>
      <td>2.51M</td>
      <td>902,573</td>
      <td>$226 - $3.6K</td>
    </tr>
    <tr>
      <td>Fri 2025-04-04</td>
      <td class="highlight">--</td>
      <td>2.51M</td>
      <td>459,622</td>
      <td>$115 - $1.8K</td>
    </tr>
    <tr>
      <td>Sat 2025-04-05</td>
      <td>10K</td>
      <td>2.52M</td>
      <td>1,144,711</td>
      <td>$286 - $4.6K</td>
    </tr>
    <tr>
      <td>Sun 2025-04-06</td>
      <td class="highlight">--</td>
      <td>2.52M</td>
      <td>468,576</td>
      <td>$117 - $1.9K</td>
    </tr>
    <tr>
      <td>Mon 2025-04-07</td>
      <td class="highlight">--</td>
      <td>2.52M</td>
      <td>381,420</td>
      <td>$95 - $1.5K</td>
    </tr>
    <tr>
      <td>Tue 2025-04-08</td>
      <td class="highlight">--</td>
      <td>2.52M</td>
      <td>915,284</td>
      <td>$229 - $3.7K</td>
    </tr>
    <tr>
      <td>Wed 2025-04-09</td>
      <td>10K</td>
      <td>2.53M</td>
      <td>575,576</td>
      <td>$144 - $2.3K</td>
    </tr>
    <tr>
      <td>Thu 2025-04-10</td>
      <td class="highlight">--</td>
      <td>2.53M</td>
      <td>789,634</td>
      <td>$197 - $3.2K</td>
    </tr>
    <tr>
      <td>Fri 2025-04-11</td>
      <td class="highlight">--</td>
      <td>2.53M</td>
      <td>757,263</td>
      <td>$189 - $3K</td>
    </tr>
    <tr>
      <td>Sat 2025-04-12</td>
      <td class="highlight">--</td>
      <td>2.53M</td>
      <td>--</td>
      <td>$0 - $0</td>
    </tr>
  </table>
  
  <h2>Daily Average</h2>
  <table>
    <tr>
      <th>Subscribers</th>
      <th>Views</th>
      <th>Videos</th>
      <th>Estimated Earnings</th>
    </tr>
    <tr>
      <td>2.3K</td>
      <td>625,116</td>
      <td>1</td>
      <td>$156 - $2.5K</td>
    </tr>
  </table>
  
  <h2>Weekly Average</h2>
  <table>
    <tr>
      <th>Subscribers</th>
      <th>Views</th>
      <th>Videos</th>
      <th>Estimated Earnings</th>
    </tr>
    <tr>
      <td>20K</td>
      <td>4,745,837</td>
      <td>6</td>
      <td>$1.2K - $19K</td>
    </tr>
  </table>
  
  <h2>Last 30 Days</h2>
  <table>
    <tr>
      <th>Subscribers</th>
      <th>Views</th>
      <th>Videos</th>
      <th>Estimated Earnings</th>
    </tr>
    <tr>
      <td>70K</td>
      <td>18,753,471</td>
      <td>24</td>
      <td>$4.7K - $75K</td>
    </tr>
  </table>
  
  <h2>Last 14 Days</h2>
  <table>
    <tr>
      <th>Subscribers</th>
      <th>Views</th>
      <th>Videos</th>
      <th>Estimated Earnings</th>
    </tr>
    <tr>
      <td>30K</td>
      <td>8,728,472</td>
      <td>15</td>
      <td>$0 - $0</td>
    </tr>
  </table>
</div>



@endsection
