<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class YoutubeController extends Controller
{
    // public function checkMonetization(Request $request)
    // {
    //     $request->validate([
    //         'channel_url' => 'required|string'
    //     ]);

    //     $channelUrl = $request->channel_url;
    //     $channelId = $this->extractChannelId($channelUrl);

    //     if (!$channelId) {
    //         return back()->with('error', 'Invalid channel URL or ID');
    //     }

    //     $apiKey = env('YOUTUBE_API_KEY');

    //     $response = Http::get("https://www.googleapis.com/youtube/v3/channels", [
    //         'part' => 'snippet,statistics,brandingSettings,contentDetails,topicDetails',
    //         'id' => $channelId,
    //         'key' => $apiKey
    //     ]);

    //     if ($response->failed() || empty($response['items'])) {
    //         return back()->with('error', 'Channel not found.');
    //     }

    //     $channel = $response['items'][0];
    //     $subscriberCount = (int) $channel['statistics']['subscriberCount'];
    //     $viewCount = (int) $channel['statistics']['viewCount'];
    //     $videoCount = (int) $channel['statistics']['videoCount'];
    //     $watchHours = rand(2000, 6000); // Simulated watch hours
    //     $eligible = $subscriberCount >= 1000 && $watchHours >= 4000;
    //     $publishedAt = $channel['snippet']['publishedAt'] ?? null;
    //     $description = $channel['snippet']['description'] ?? '';
    //     $country = $channel['snippet']['country'] ?? 'N/A';
    //     $topics = $channel['topicDetails']['topicCategories'] ?? [];

    //     $profilePicture = $channel['snippet']['thumbnails']['high']['url'] ?? null;
    //     $thumbnails = $channel['snippet']['thumbnails'];
    //     $profilePictures = [];
    //     foreach ($thumbnails as $key => $thumb) {
    //         $profilePictures[$key] = $thumb['url'];
    //     }

    //     $coverArtBase = $channel['brandingSettings']['image']['bannerExternalUrl'] ?? '';
    //     $coverSizes = [
    //         '2120x1192', '2120x351', '1920x1080', '2560x424', '1280x720', '2276x377',
    //         '1440x395', '1707x283', '1280x351', '854x480', '960x263', '1138x188',
    //         '1060x175', '640x175', '320x180', '320x88'
    //     ];
    //     $coverImages = [];
    //     foreach ($coverSizes as $size) {
    //         $width = explode('x', $size)[0];
    //         $coverImages[$size] = $coverArtBase . "=w{$width}-k-c0xffffffff-no-nd-rj";
    //     }

    //     $isVerified = $channel['brandingSettings']['channel']['keywords'] ?? false;
    //     $hasJoinButton = $subscriberCount >= 1000; // Approximation

    //     return view('welcome', [
    //         'title' => $channel['snippet']['title'],
    //         'subscribers' => $subscriberCount,
    //         'views' => $viewCount,
    //         'watchHours' => $watchHours,
    //         'eligible' => $eligible,
    //         'channel_id' => $channelId,
    //         'created_at' => $publishedAt,
    //         'video_count' => $videoCount,
    //         'description' => $description,
    //         'country' => $country,
    //         'topics' => $topics,
    //         'profile_picture' => $profilePicture,
    //         'cover_art' => $coverArtBase,
    //         'profile_pictures' => $profilePictures,
    //         'cover_images' => $coverImages,
    //         'is_verified' => $isVerified,
    //         'has_join_button' => $hasJoinButton,
    //     ]);
    // }

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


    public function ajaxCheckMonetization(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'encrypted' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid data provided.'], 422);
        }

        // Simulated "decryption"
        $channelUrl = base64_decode($request->encrypted);
        $channelId = $this->extractChannelId($channelUrl);

        if (!$channelId) {
            return response()->json(['message' => 'Invalid channel URL or ID.'], 422);
        }

        $apiKey = env('YOUTUBE_API_KEY');

        $response = Http::get("https://www.googleapis.com/youtube/v3/channels", [
            'part' => 'snippet,statistics,brandingSettings,contentDetails,topicDetails',
            'id' => $channelId,
            'key' => $apiKey
        ]);

        if ($response->failed() || empty($response['items'])) {
            return response()->json(['message' => 'Channel not found.'], 404);
        }
        // dd($response);
        $channel = $response['items'][0];
        $subscriberCount = (int) $channel['statistics']['subscriberCount'];
        $viewCount = (int) $channel['statistics']['viewCount'];
        $videoCount = (int) $channel['statistics']['videoCount'];
        $watchHours = rand(2000, 6000);
        $eligible = $subscriberCount >= 1000 && $watchHours >= 4000;
        $publishedAt = $channel['snippet']['publishedAt'] ?? null;
        $country = $channel['snippet']['country'] ?? 'N/A';
        $topics = $channel['topicDetails']['topicCategories'] ?? [];

        $thumbnails = $channel['snippet']['thumbnails'];
        $profilePictures = [];
        foreach ($thumbnails as $key => $thumb) {
            $profilePictures[$key] = $thumb['url'];
        }

        $coverArtBase = $channel['brandingSettings']['image']['bannerExternalUrl'] ?? '';
        $coverSizes = ['2120x1192', '2120x351', '1920x1080'];
        $coverImages = [];
        foreach ($coverSizes as $size) {
            $width = explode('x', $size)[0];
            $coverImages[$size] = $coverArtBase . "=w{$width}-k-c0xffffffff-no-nd-rj";
        }

        
        $data = [
            'status' => 'success',
            'data' => [
                'title' => $channel['snippet']['title'],///
                'title2' => $channel['snippet']['customUrl'],///
                'subscribers' => $subscriberCount,///
                'views' => $viewCount,///
                'watchHours' => $watchHours,
                'eligible' => $eligible,
                'channel_id' => $channelId,
                'created_at' => $publishedAt,
                'video_count' => $videoCount,
                'country' => $country,
                'topics' => $topics,
                'profile_pictures' => $profilePictures,
                'cover_images' => $coverImages,
                'is_verified' => !empty($channel['brandingSettings']['channel']['keywords']),
                'has_join_button' => $subscriberCount >= 1000,
            ]
        ];
        // dd($data);
        // Use only channel_id for route parameter
        $slug = $this->makeSlug($channel['snippet']['title']);

        $redirectUrl = route('channel', ['slug' => $slug]);

        session(['channel_data' => $data['data']]);

        return response()->json([
            'redirectUrl' => $redirectUrl,
            'stats' => $data['data'], // send only inner data, not status wrapper
        ]);
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
}
