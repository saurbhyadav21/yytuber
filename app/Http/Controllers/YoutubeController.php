<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use DB;
class YoutubeController extends Controller
{
   

    public function checkMonetization(Request $request)
    {
        $url = base64_decode($request->encrypted);
    
        // Your logic to fetch data from API or scrape
        $channel = [/* channel data */];
        $daily_metrics = [/* stats */];
    
        // Store in session
        session([
            'channel' => $channel,
            'daily_metrics' => $daily_metrics,
        ]);
    
        return response()->json([
            'status' => true
        ]);
    }

    private function extractChannelId($url)
    {
        // If it's already a valid channel ID
        if (preg_match('/^UC[a-zA-Z0-9_-]{21}[AQgw]$/', $url)) {
            return $url;
        }

        // Match standard channel URL
        if (preg_match('/youtube\.com\/channel\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        // Handle: youtube.com/@handle
        if (preg_match('/youtube\.com\/@([a-zA-Z0-9._-]+)/', $url, $matches)) {
            $customHandle = $matches[1];

            $response = Http::get("https://www.googleapis.com/youtube/v3/search", [
                'part' => 'snippet',
                'q' => $customHandle,
                'type' => 'channel',
                'maxResults' => 1,
                'key' => env('YOUTUBE_API_KEY'),
            ]);

            if ($response->successful() && !empty($response['items'])) {
                return $response['items'][0]['snippet']['channelId'];
            }
        }

        return null;
    }


    // public function ajaxCheckMonetization(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'encrypted' => 'required|string'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['message' => 'Invalid data provided.'], 422);
    //     }

    //     // Simulated "decryption"
    //     $channelUrl = base64_decode($request->encrypted);
    //     $channelId = $this->extractChannelId($channelUrl);
    //     // dd( $channelId);
    //     if (!$channelId) {
    //         return response()->json(['message' => 'Invalid channel URL or ID.'], 422);
    //     }

    //     $apiKey = env('YOUTUBE_API_KEY');

    //     $response = Http::get("https://www.googleapis.com/youtube/v3/channels", [
    //         'part' => 'snippet,statistics,brandingSettings,contentDetails,topicDetails',
    //         'id' => $channelId,
    //         'key' => $apiKey
    //     ]);

    //     if ($response->failed() || empty($response['items'])) {
    //         return response()->json(['message' => 'Channel not found.'], 404);
    //     }
    //     // dd($response);
    //     $channel = $response['items'][0];
    //     $subscriberCount = (int) $channel['statistics']['subscriberCount'];
    //     $viewCount = (int) $channel['statistics']['viewCount'];
    //     $videoCount = (int) $channel['statistics']['videoCount'];
    //     $watchHours = rand(2000, 6000);
    //     $eligible = $subscriberCount >= 1000 && $watchHours >= 4000;
    //     $publishedAt = $channel['snippet']['publishedAt'] ?? null;
    //     $country = $channel['snippet']['country'] ?? 'N/A';
    //     $topics = $channel['topicDetails']['topicCategories'] ?? [];

    //     $thumbnails = $channel['snippet']['thumbnails'];
    //     $profilePictures = [];
    //     foreach ($thumbnails as $key => $thumb) {
    //         $profilePictures[$key] = $thumb['url'];
    //     }

    //     $coverArtBase = $channel['brandingSettings']['image']['bannerExternalUrl'] ?? '';
    //     $coverSizes = ['2120x1192', '2120x351', '1920x1080'];
    //     $coverImages = [];
    //     foreach ($coverSizes as $size) {
    //         $width = explode('x', $size)[0];
    //         $coverImages[$size] = $coverArtBase . "=w{$width}-k-c0xffffffff-no-nd-rj";
    //     }

        
    //     $data = [
    //         'status' => 'success',
    //         'data' => [
    //             'title' => $channel['snippet']['title'],///
    //             'title2' => $channel['snippet']['customUrl'],///
    //             'subscribers' => $subscriberCount,///
    //             'views' => $viewCount,///
    //             'watchHours' => $watchHours,
    //             'eligible' => $eligible,
    //             'channel_id' => $channelId,
    //             'created_at' => $publishedAt,
    //             'video_count' => $videoCount,
    //             'country' => $country,
    //             'topics' => $topics,
    //             'profile_pictures' => $profilePictures,
    //             'cover_images' => $coverImages,
    //             'is_verified' => !empty($channel['brandingSettings']['channel']['keywords']),
    //             'has_join_button' => $subscriberCount >= 1000,
    //         ]
    //     ];
    //     // dd($data);
    //     // Use only channel_id for route parameter
    //     $slug = $this->makeSlug($channel['snippet']['title']);

    //     $redirectUrl = route('channel', ['slug' => $slug]);

    //     session(['channel_data' => $data['data']]);

    //     return response()->json([
    //         'redirectUrl' => $redirectUrl,
    //         'stats' => $data['data'], // send only inner data, not status wrapper
    //     ]);
    // }


    public function ajaxCheckMonetization(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'encrypted' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided.'], 422);
        }

        $channelUrl = base64_decode($request->encrypted);
        $channelId = $this->extractChannelId($channelUrl);

        if (!$channelId) {
            return response()->json(['message' => 'Invalid channel URL or ID.'], 422);
        }

        $channel_search = DB::table('channel_search')
            ->where('channel_id', $channelId)
            ->first(); // Returns the first result (or null if no match is found)

        if ($channel_search) {
            // Data found
            // You can access like: $channel_search->channel_name, $channel_search->description, etc.
            // Example:
            // echo "Channel found: " . $channel_search->channel_name;
            $data_db = $channel_search->api_response;
            $data_1 = json_decode($data_db, TRUE);
            $data = $data_1['data'];
            // dd($data['data']);
            // dd($data['tags'][0]);

            $slug = $this->makeSlug($data['sl']);
            $redirectUrl = route('channel', ['slug' => $slug]);

            // // Store in session
            session(['channel_data' => $data]);

            return response()->json([
                'redirectUrl' => $redirectUrl,
                'stats' => $data,
            ]);

        } else {
            $apiKey = env('YOUTUBE_API_KEY');

        $response = Http::get("https://www.googleapis.com/youtube/v3/channels", [
            'part' => 'snippet,statistics,brandingSettings,contentDetails,topicDetails',
            'id' => $channelId,
            'key' => $apiKey
        ]);

        if ($response->failed() || empty($response['items'])) {
            return response()->json(['message' => 'Channel not found.'], 404);
        }

        $channel = $response['items'][0];
        $subscriberCount = (int) $channel['statistics']['subscriberCount'];
        $viewCount = (int) $channel['statistics']['viewCount'];
        $videoCount = (int) $channel['statistics']['videoCount'];
        $watchHours = rand(2000, 6000); // Dummy data
        $eligible = $subscriberCount >= 1000 && $watchHours >= 4000;
        $publishedAt = $channel['snippet']['publishedAt'] ?? null;
        $country = $channel['snippet']['country'] ?? 'N/A';
        $topics = $channel['topicDetails']['topicCategories'] ?? [];

        // Thumbnail Images
        $thumbnails = $channel['snippet']['thumbnails'];
        $profilePictures = [];
        foreach ($thumbnails as $key => $thumb) {
            $profilePictures[$key] = $thumb['url'];
        }

        // Cover Images
        $coverArtBase = $channel['brandingSettings']['image']['bannerExternalUrl'] ?? '';
        $coverSizes = ['2120x1192', '2120x351', '1920x1080'];
        $coverImages = [];
        foreach ($coverSizes as $size) {
            $width = explode('x', $size)[0];
            $coverImages[$size] = $coverArtBase . "=w{$width}-k-c0xffffffff-no-nd-rj";
        }

        // Estimate views (dummy logic, adjust with real if you get them from elsewhere)
        $viewsPerDay = round($viewCount / 365); // very rough estimate
        $viewsPerHour = round($viewsPerDay / 24);

        // CPM Estimation (USD per 1000 views)
        // $lowCPM = 1.5;
        // $highCPM = 4.0;
        $categoryCPM = $this->detectCPMByCategory($topics);
        $countryCPM = $this->detectCPMByCountry($country);
        $cpmRates = $this->getFinalCPM($categoryCPM, $countryCPM);
        // Earning Calculation
        $earnings = [
            'hourly' => [
                'min' => round(($viewCount / 365 / 24 / 1000) * $cpmRates['min'], 2),
                'max' => round(($viewCount / 365 / 24 / 1000) * $cpmRates['max'], 2),
            ],
            'daily' => [
                'min' => round(($viewCount / 365 / 1000) * $cpmRates['min'], 2),
                'max' => round(($viewCount / 365 / 1000) * $cpmRates['max'], 2),
            ],
            'weekly' => [
                'min' => round(($viewCount / 52 / 1000) * $cpmRates['min'], 2),
                'max' => round(($viewCount / 52 / 1000) * $cpmRates['max'], 2),
            ],
            'yearly' => [
                'min' => round(($viewCount / 1000) * $cpmRates['min'], 2),
                'max' => round(($viewCount / 1000) * $cpmRates['max'], 2),
            ],
        ];
            // Construct Channel URL
        $channelUrlFinal = "https://www.youtube.com/channel/{$channelId}";

        // Calculate age
        $createdDate = Carbon::parse($publishedAt);
        $now = Carbon::now();
        $daysOld = $createdDate->diffInDays($now);
        $createdDateFormatted = $createdDate->isoFormat('MMM D, YYYY') . " 【" . $createdDate->diffForHumans($now, ['short' => true, 'parts' => 3]) . "】";

        // Dial Code Mapping (can be extended)
        $dialCodes = [
            'IN' => '+91',
            'US' => '+1',
            'UK' => '+44',
            // Add more as needed
        ];
        $dialCode = $dialCodes[$country] ?? 'N/A';

        // Religion Mapping (rough guess)
        $religionMap = [
            'IN' => 'Hinduism',
            'US' => 'Christianity',
            'PK' => 'Islam',
            // Add more if needed
        ];
        $religion = $religionMap[$country] ?? 'Unknown';
        $totalDays = $createdDate->diffInDays(Carbon::now());
        $totalDays = max($totalDays, 1); // avoid divide by zero

        // Averages for Subscribers
        $dailySubscribers = round($subscriberCount / $totalDays, 2);
        $weeklySubscribers = round($dailySubscribers * 7, 2);
        $monthlySubscribers = round($dailySubscribers * 30, 2);
        $fortnightSubscribers = round($dailySubscribers * 14, 2);

        // Averages for Views
        $dailyViews = round($viewCount / $totalDays, 2);
        $weeklyViews = round($dailyViews * 7, 2);
        $monthlyViews = round($dailyViews * 30, 2);
        $fortnightViews = round($dailyViews * 14, 2);

        // Averages for Videos
        $dailyVideos = round($videoCount / $totalDays, 2);
        $weeklyVideos = round($dailyVideos * 7, 2);
        $monthlyVideos = round($dailyVideos * 30, 2);
        $fortnightVideos = round($dailyVideos * 14, 2);

        // Averages for Estimated Earnings (based on daily earnings already calculated)
        $dailyEarningMin = $earnings['daily']['min'];
        $dailyEarningMax = $earnings['daily']['max'];

        $weeklyEarningMin = round($dailyEarningMin * 7, 2);
        $weeklyEarningMax = round($dailyEarningMax * 7, 2);

        $monthlyEarningMin = round($dailyEarningMin * 30, 2);
        $monthlyEarningMax = round($dailyEarningMax * 30, 2);

        $fortnightEarningMin = round($dailyEarningMin * 14, 2);
        $fortnightEarningMax = round($dailyEarningMax * 14, 2);
        // Keywords (tags)
        $tags = $channel['brandingSettings']['channel']['keywords'] ?? '';
        $tagsList = array_filter(array_map('trim', explode(',', $tags)));
        
        // Response data
        $data = [
            'status' => 'success',
            'data' => [
                'title' => $channel['snippet']['title'],
                'title2' => $channel['snippet']['customUrl'] ?? '',
                'subscribers' => $subscriberCount,
                'views' => $viewCount,
                'sl'=>$channel['snippet']['title'],
                'watchHours' => $watchHours,///
                'eligible' => $eligible,///
                'channel_id' => $channelId,///
                'created_at' => $publishedAt,////
                'video_count' => $videoCount,///
                'country' => $country,//
                'topics' => $topics,///
                'profile_pictures' => $profilePictures,
                'cover_images' => $coverImages,
                'is_verified' => !empty($channel['brandingSettings']['channel']['keywords']),///
                'has_join_button' => $subscriberCount >= 1000,/////
                'earnings' => $earnings,/////
                // Channel metadata (example - you can adjust this logic as needed)
                'channel_url' => $channelUrlFinal,
                'channel_age_days' => $daysOld,
                'channel_created_date_formatted' => $createdDateFormatted,
                'dial_code' => $dialCode,
                'religion' => $religion,
                'tags' => $tagsList,
                'description' => $channel['snippet']['description'] ?? '',
                'estimated_stats' => [
                'subscribers' => [
                    'daily' => $dailySubscribers,
                    'weekly' => $weeklySubscribers,
                    'fortnight' => $fortnightSubscribers,
                    'monthly' => $monthlySubscribers,
                ],
                'views' => [
                    'daily' => $dailyViews,
                    'weekly' => $weeklyViews,
                    'fortnight' => $fortnightViews,
                    'monthly' => $monthlyViews,
                ],
                'videos' => [
                    'daily' => $dailyVideos,
                    'weekly' => $weeklyVideos,
                    'fortnight' => $fortnightVideos,
                    'monthly' => $monthlyVideos,
                ],
                'earnings' => [
                    'daily' => [
                        'min' => $dailyEarningMin,
                        'max' => $dailyEarningMax,
                    ],
                    'weekly' => [
                        'min' => $weeklyEarningMin,
                        'max' => $weeklyEarningMax,
                    ],
                    'fortnight' => [
                        'min' => $fortnightEarningMin,
                        'max' => $fortnightEarningMax,
                    ],
                    'monthly' => [
                        'min' => $monthlyEarningMin,
                        'max' => $monthlyEarningMax,
                    ],
                ]
                ]
            ]
        ];

            $data_insert = [
                'channel_id' => $channelId,
                'api_response' => json_encode($data),
                'created_at' => now(),  // Optional if you have timestamps
                'last_updated_date' => now(),  // Optional if you have timestamps
            ];
            
            DB::table('channel_search')->insert($data_insert);


            // dd($data);
            // Slug route
            // $data = json_decode($data, TRUE);
            // print_r( $data );   
            $slug = $this->makeSlug($channel['snippet']['title']);
            $redirectUrl = route('channel', ['slug' => $slug]);

            // Store in session
            session(['channel_data' => $data['data']]);

            return response()->json([
                'redirectUrl' => $redirectUrl,
                'stats' => $data['data'],
            ]);
        }

        
        
    }

    public function showChannelStats(Request $request)
    {
        // Decrypt the encrypted data
        $encryptedData = $request->input('encrypted');
        $decryptedData = Crypt::decryptString($encryptedData);
    
        // Assuming $decryptedData is JSON or an array
        $stats = json_decode($decryptedData, true);
    
        // Construct the URL to redirect to
        $redirectUrl = route('channel.stats');
    
        // You can optionally pass the stats to the view if needed
        return response()->json([
            'redirectUrl' => $redirectUrl,
            'stats' => $stats,
        ]);
    }
    



public function index(Request $request)
{
    // Retrieve the stats from the session
    $stats = session('stats');

    // Render the 'channel_stats' view with the data
    return view('channel_stats', compact('stats'));
}

function makeSlug($string) {
    // Convert to lowercase
    $slug = strtolower($string);

    // Remove special characters
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

    // Replace multiple spaces or hyphens with a single hyphen
    $slug = preg_replace('/[\s-]+/', '-', $slug);

    // Trim leading and trailing hyphens
    $slug = trim($slug, '-');

    return $slug;
}



public function show($slug)
{
    // Fetch data based on slug or session
    // Option 1: If you passed data via session
    if (session()->has('channel_data')) {
        $data = session('channel_data');
    } else {
        // Option 2: Fetch again via API or DB using slug (if session is not used)
        return redirect()->route('home')->with('error', 'No channel data found.');
    }

    return view('channel_stats', compact('data'));
}


function detectCPMByCategory(array $topics): array {
    $categories = [
        'finance' => [15.0, 25.0],
        'business' => [15.0, 25.0],
        'technology' => [8.0, 15.0],
        'software' => [8.0, 15.0],
        'education' => [4.0, 10.0],
        'gaming' => [1.5, 4.0],
        'entertainment' => [1.5, 4.0],
        'vlog' => [2.0, 5.0],
        'lifestyle' => [2.0, 5.0],
        'kids' => [0.5, 2.0],
    ];

    foreach ($topics as $topic) {
        foreach ($categories as $keyword => $cpm) {
            if (stripos($topic, $keyword) !== false) {
                return ['min' => $cpm[0], 'max' => $cpm[1]];
            }
        }
    }

    return ['min' => 1.5, 'max' => 4.0]; // default CPM
}

function detectCPMByCountry(?string $country): array {
    $country = strtolower($country ?? '');
    if (in_array($country, ['us', 'gb', 'uk', 'ca'])) {
        return ['min' => 6.0, 'max' => 12.0];
    } elseif (in_array($country, ['au', 'nz'])) {
        return ['min' => 5.0, 'max' => 10.0];
    } elseif (in_array($country, ['fr', 'de', 'nl', 'se'])) {
        return ['min' => 4.0, 'max' => 8.0];
    } elseif (in_array($country, ['in', 'ph', 'bd'])) {
        return ['min' => 0.5, 'max' => 2.0];
    } else {
        return ['min' => 1.5, 'max' => 4.0];
    }
}

function getFinalCPM(array $categoryCPM, array $countryCPM): array {
    return [
        'min' => max($categoryCPM['min'], $countryCPM['min']),
        'max' => max($categoryCPM['max'], $countryCPM['max']),
    ];
}

}
