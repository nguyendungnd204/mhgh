<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\NewsService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function __construct(
        private EventService $eventService,
        private NewsService $newsService,
    ){}

     public function index(Request $request)
    {
        $events = $this->eventService->getActiveEvents(5);
        $news = $this->newsService->getActiveNews(5); 
        //$guides = $this->guideService->getActiveGuides(10);


        return view('home.index', compact('events', 'news'));
    }
}
