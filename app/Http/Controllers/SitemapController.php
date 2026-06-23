<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index()
    {
        $routes = collect(Route::getRoutes())
            ->filter(function ($route) {
                return in_array('GET', $route->methods())
                    && !str_contains($route->uri(), '{')
                    && !str_starts_with($route->uri(), '_')
                    && $route->uri() !== 'sitemap.xml';
            });

        return response()
            ->view('sitemap', compact('routes'))
            ->header('Content-Type', 'text/xml');
    }
}