<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class ArticleRepository
{
    public function getLatestArticles($perPage = 4)
    {
        $response = Http::get('http://artikel.bumirealty.id/wp-json/wp/v2/posts', [
            'per_page' => $perPage,
            '_embed' => true
        ]);

        if (!$response->successful()) {
            return [];
        }

        $raw = $response->json();
        $articles = [];
        foreach ($raw as $item) {
            $articles[] = [
                'thumbnail' => $item['_embedded']['wp:featuredmedia'][0]['source_url'] ?? null,
                'date'      => $item['date'],
                'url'       => $item['link'],
                'title'     => $item['title']['rendered'] ?? null, // Tambah judul
            ];
        }
        return $articles;
    }
}