<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()

            ->add(
                Url::create('/')
                    ->setPriority(1.0)
            )

            ->add(
                Url::create('/youtube-thumbnail-downloader')
                    ->setPriority(0.9)
            )

            ->add(
                Url::create('/youtube-tag-extractor')
                    ->setPriority(0.9)
            );

        return response($sitemap->render())
            ->header('Content-Type', 'application/xml');
    }
}