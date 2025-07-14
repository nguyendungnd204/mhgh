<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsService 
{
    protected $newsRepository;

    public function __construct(NewsRepository $newsRepository) 
    {
        $this->newsRepository = $newsRepository;
    }
    public function getAllNews(Request $request)
    {
        $query = $this->newsRepository->getQuerywithRelations(['user', 'contentBlocks']);

        if($request->filled('search')) 
        {
            $query = $this->newsRepository->search($query, $request->search);
        }

        return $this->newsRepository->paginate($query, 10);
    }
}