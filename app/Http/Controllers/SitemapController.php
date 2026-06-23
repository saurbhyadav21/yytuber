<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $content = view('sitemap')->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}