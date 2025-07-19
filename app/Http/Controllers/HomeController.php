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

    public function news()
    {
        $news = $this->newsService->getActiveNews(10); 

        return view('home.news', compact('news'));
    }

    public function events()
    {
        $events = $this->eventService->getActiveEvents(10);

        return view('home.events', compact('events'));
    }

    public function showEvent(int $id)
    {
        $event = $this->eventService->getActiveEventById($id);

        if (!$event) {
            abort(404, 'Sự kiện không tồn tại');
        }

        return view('home.show-event', compact('event'));
    }

    public function showNews(int $id)
    {
        $news = $this->newsService->getActiveNewsById($id);

        if (!$news) {
            abort(404, 'Tin tức không tồn tại');
        }

        return view('home.show-news', compact('news'));
    }
}
