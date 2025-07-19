<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YoutubeController;

Route::get('/', function () {return view('home');});

Route::get('/about', function () {return view('about');});
Route::get('/contact', function () {return view('contact');});
Route::get('/privacy', function () {return view('privacy-policy');});
Route::get('/terms', function () {return view('terms');});
// Route::get('/', function () {return view('welcome');});
// Route::get('/', function () {return view('welcome');});
Route::get('/youtube-thumbnail', function () {return view('imagetools.youtubeThumbnail');});
Route::get('/profile-pictures', function () {return view('imagetools.profilePictures');});
Route::get('/banner-download', function () {return view('imagetools.banner');});


Route::get('/youtube', function () {
    return view('welcome');
});

// Route::post('/check-monetization', [YoutubeController::class, 'checkMonetization'])->name('check.monetization');
Route::post('/check-monetization', [YoutubeController::class, 'ajaxCheckMonetization'])->name('check.monetization');

// Route::get('youtube/channel/{slug}', [YoutubeController::class, 'index'])->name('channel');
Route::get('youtube/channel/{slug}', [YoutubeController::class, 'show'])->name('channel');
// Route::post('/check-monetization-enc', [YoutubeController::class, 'showChannelStats'])->name('check.monetization.enc');


