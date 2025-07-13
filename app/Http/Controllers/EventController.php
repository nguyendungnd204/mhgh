<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\EventService;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request): View
    {
        $events = $this->eventService->getAllEvents($request);
        
        return view('events.index', compact('events'));
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        try {
            $this->eventService->createEvent($request->validated(), $request);
            
            return redirect()->route('admin.events.index')
                           ->with('success', 'Event created successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create event: ' . $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        $event = $this->eventService->getEventById($id);
        
        return view('events.show', compact('event'));
    }

    public function edit(int $id): View
    {
        $event = $this->eventService->getEventById($id);
        
        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        try {
            $this->eventService->updateEvent($event, $request->validated(), $request);
            
            return redirect()->route('admin.events.index')
                           ->with('success', 'Cập nhật sự kiện thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(Event $event): RedirectResponse
    {
        try {
            $this->eventService->deleteEvent($event);
            
            return redirect()->route('admin.events.index')
                           ->with('success', 'Event deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete event: ' . $e->getMessage());
        }
    }
}