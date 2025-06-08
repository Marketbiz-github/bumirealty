<?php

namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticleService
{
    protected $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function getLatestArticles($perPage = 4)
    {
        return $this->articleRepo->getLatestArticles($perPage);
    }
}