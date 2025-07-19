<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\GiftService;
use App\Services\NewsService;
use App\Services\TransactionService;
use App\Services\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private TransactionService $transactionService,
        private UserService $userService,
        private EventService $eventService,
        private NewsService $newsService,
        private GiftService $giftService
    ){}

    public function index(Request $request)
    {
        $eventCount = $this->eventService->count();
        $newsCount = $this->newsService->count();
        $giftCount = $this->giftService->count();
        $userCount = $this->userService->count();
        $transactionCount = $this->transactionService->count();

        $transactions = $this->transactionService->getTransactionsRecentlyCreated(7);
        $events = $this->eventService->getUpcomingEvents();

        return view('admin.dashboard', compact(
            'eventCount',
            'newsCount',
            'giftCount',
            'userCount',
            'transactionCount',
            'transactions',
            'events'
        ));
    }
}
