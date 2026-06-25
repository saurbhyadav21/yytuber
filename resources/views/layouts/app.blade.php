<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>YYtuber - Analyze & Monetize Your YouTube Channel</title>
    <meta name="description"
        content="Get real-time YouTube channel analytics, earnings estimate, and monetization tools with YYtuber. Grow your channel smarter.">
    <meta name="keywords"
        content="YouTube analytics, monetize YouTube, YouTube stats, YYtuber, channel earnings, YouTube income calculator">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>YYTuber Checker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="canonical" href="{{ url()->current() }}">
    {{-- <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"Organization",
      "name":"YYTuber",
      "url":"https://yytuber.com",
      "logo":"https://yytuber.com/logo.png",
      "description":"Free YouTube tools for creators including Monetization Checker, Channel Stats, Tag Extractor, Profile Picture Downloader, and more.",
      "email":"support@yytuber.com",
      "sameAs":[
        "https://facebook.com/yourpage",
        "https://x.com/yourprofile",
        "https://instagram.com/yourprofile",
        "https://youtube.com/@yourchannel"
      ]
    }
    </script> --}}
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #0d0d0d;
            color: white;
        }

        header {
            background-color: #111;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
        }

        .logo img {
            max-height: 60px;
        }

        nav a {
            color: #fff;
            margin: 0 1rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #ff0000;
        }

        .hero {
            text-align: center;
            padding: 11rem 1rem;
            border-top: 1px solid white;
            background: linear-gradient(to right, #850000, #1a1a1a)
        }

        .hero h1 {
            font-size: 5.5rem;
            font-weight: bold;
            /* color: #ff0000; */
        }

        .hero p {
            color: #ccc;
            margin-bottom: 1.5rem;
            font-size: 22px;
        }

        .hero input[type="text"] {
            width: 75%;
            /* max-width: 500px; */
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .hero button {
            background: linear-gradient(to right, #850000, #1a1a1a);
            color: white;
            border: 1px solid;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .hero button:hover {
            background-color: #e60000;
        }

        .tags a {
            margin: 0.4rem;
            display: inline-block;
            padding: 10px 14px;
            border: 1px solid white;
            color: white;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
        }

        .tags a:hover {
            background-color: red;
            color: white;
        }

        .channel-table {
            width: 100%;
            margin: 2rem 0;
        }

        th {
            color: white !important;
        }

        .channel-table th,
        .channel-table td {
            border: 1px solid #333;
            padding: 12px;
        }

        .channel-table th {
            background-color: red;
        }

        .stats-preview {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #1a1a1a;
            padding: 2rem;
        }

        .stat-card {
            color: #fff;
            background-color: #111;
            margin: 1rem;
            padding: 1.5rem 2rem;
            border-left: 5px solid #ff0000;
            border-radius: 8px;
            font-size: 1.2rem;
            min-width: 250px;
            box-shadow: 0 0 10px #000;
        }

        footer {
            background-color: #111;
            text-align: center;
            padding: 2rem 1rem;
            color: white;
        }

        footer a {
            color: #ff0000;
            margin: 0 10px;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <style>
        #monetizationForm input {
            width: 485px;
            padding: 6px;
            height: 40px;
            border-radius: 5px;
        }

        #monetizationForm button {
            padding: 8px 15px;
        }

        .m_button {
            background: linear-gradient(to right, #850000, #1a1a1a);
            color: white;
            border: 1px solid;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        header {
            box-shadow: 0 0 25px #ff0000;
        }
    </style>
    <header class="d-flex align-items-center justify-content-between">
        <div id="loader"
            style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 0, 0, 0.5); /* Red transparent */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    display: none; /* Hide by default */
  ">
            <img src="https://cssbud.com/wp-content/uploads/2022/05/pendulum.gif"
                style="
      
      object-fit: contain;
    ">
        </div>

        <div class="logo">
            <a href="{{ url('/') }}"><img src="{{ asset('public/images/logo.png') }}" alt="YYTuber Logo"></a>
        </div>
        @if (!request()->is('/'))
            <form id="monetizationForm" style="display: flex; gap: 10px;">
                @csrf
                <input type="text" placeholder="Enter YouTube Channel ID or URL" name="channel_url"
                    id="channel_url" />
                <button type="submit" class="m_button"><i class="bi bi-search"></i> Check Now</button>
            </form>
            <div id="result" class="mt-6"></div>
        @endif

        <nav class="relative">
            {{-- <div class="dropdown" style="display: inline-block; position: relative;">
        <a href="#" class="dropdown-toggle" style="cursor: pointer; color: white;">Tools</a>
        <div class="dropdown-menu" style="
          display: none;
          position: absolute;
          top: 100%;
          left: 0;
          background-color: rgba(255, 0, 0, 0.8); /* red transparent */
          padding: 10px;
          z-index: 999;
          min-width: 180px;
          border-radius: 6px;
        ">
          <a href="{{ url('/') }}" style="display: block; padding: 8px 10px; color: white; text-decoration: none;">Monetization Checker</a>
          
        </div>
      </div>
      <a href="{{url('/')}}">Home</a>
      <a href="{{url('/about')}}">About</a>
      <a href="{{url('/')}}">Blog</a>
      <a href="{{url('/contact')}}">Contact</a>
    
      
    </nav>
    

    <meta name="csrf-token" content="{{ csrf_token() }}">
  </header>

    <!-- Page Content -->
    {{-- <div class="container"> --}}
            @yield('content')
            {{-- </div> --}}

            <footer>
                <p>© 2025 YYTuber. All rights reserved.</p>
                <div class="mt-2">
                    <a href="{{ url('/about') }}">About Us</a> |
                    <a href="{{ url('/') }}">Blog</a> |
                    <a href="{{ url('/contact') }}">Contact Us</a> |
                    <a href="{{ url('/privacy') }}">Privacy Policy</a> |
                    <a href="{{ url('/terms') }}">Terms of Use</a>
                </div>
            </footer>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script>
                document.getElementById('monetizationForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const loader = document.getElementById('loader');
                    const result = document.getElementById('result');

                    loader.style.display = 'flex'; // Show loader
                    result.innerHTML = '';

                    const channelUrl = document.getElementById('channel_url').value.trim();
                    if (!channelUrl) {
                        loader.style.display = 'none'; // Hide loader if empty input
                        alert('Please enter a channel URL or ID.');
                        return;
                    }

                    const encryptedData = btoa(channelUrl);

                    axios.post("{{ route('check.monetization') }}", {
                            encrypted: encryptedData
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => {
                            loader.style.display = 'none'; // Hide loader
                            const stats = response.data.stats;

                            document.getElementById('result').innerHTML = `
          <h2>${stats.title}</h2>
          <p>Subscribers: ${stats.subscribers}</p>
          <p>Views: ${stats.views}</p>
          <p>Watch Hours: ${stats.watchHours}</p>
          <p>Eligible: ${stats.eligible ? 'Yes' : 'No'}</p>
      `;

                            if (response.data.redirectUrl) {
                                window.location.href = response.data.redirectUrl;
                            }
                        })
                        .catch(error => {
                            loader.style.display = 'none'; // Hide loader
                            alert(error.response?.data?.message || 'Something went wrong!');
                        });
                });
            </script>
            {{-- <script>

  document.querySelector('.dropdown-toggle').addEventListener('click', function (e) {
    e.preventDefault();
    const menu = this.nextElementSibling;
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
  });

  window.addEventListener('click', function (e) {
    if (!e.target.closest('.dropdown')) {
      document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');
    }
  });


</script> --}}

            <script>
                document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();

                        const currentMenu = this.nextElementSibling;

                        // Close all dropdowns first
                        document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                            if (menu !== currentMenu) {
                                menu.style.display = 'none';
                            }
                        });

                        // Toggle the clicked one
                        currentMenu.style.display = (currentMenu.style.display === 'block') ? 'none' : 'block';
                    });
                });

                // Close all when clicking outside
                window.addEventListener('click', function(e) {
                    if (!e.target.closest('.dropdown')) {
                        document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');
                    }
                });
            </script>



</body>

</html>
