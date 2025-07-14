<?php

namespace App\Http\Controllers;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        $news = $this->newsService->getAllNews($request);

        return view('news.index', compact('news'));
    }
}
