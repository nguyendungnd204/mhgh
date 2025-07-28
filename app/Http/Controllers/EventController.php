<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\EventService;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{

    public function __construct(private EventService $eventService)
    {
        /** @var \Illuminate\Routing\Controller $this */
        $this->middleware('can:view events')->only('index', 'show');
        $this->middleware('can:create events')->only('create', 'store');
        $this->middleware('can:edit events')->only('edit', 'update');
    }

    public function index(Request $request): View
    {
        if(!Auth::user()->can('view events'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $events = $this->eventService->getAllEvents($request);
        
        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        if(!Auth::user()->can('create events'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        if(!Auth::user()->can('create events'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        try {
            $this->eventService->createEvent($request->validated(), $request);
            
            return redirect()->route('admin.events.index')
                           ->with('success', 'Tạo sự kiện thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Có lỗi khi tạo: ' . $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        if(!Auth::user()->can('view events'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $event = $this->eventService->getEventById($id);
        
        return view('admin.events.show', compact('event'));
    }

    public function edit(int $id): View
    {
        if(!Auth::user()->can('edit events'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $event = $this->eventService->getEventById($id);
        
        return view('admin.events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, int $id): RedirectResponse
    {
        if(!Auth::user()->can('edit events'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $event = $this->eventService->getEventById($id);

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

    // public function destroy(Event $event): RedirectResponse
    // {
    //     try {
    //         $this->eventService->deleteEvent($event);
            
    //         return redirect()->route('admin.events.index')
    //                        ->with('success', 'Event deleted successfully');
    //     } catch (\Exception $e) {
    //         return redirect()->back()
    //                        ->with('error', 'Failed to delete event: ' . $e->getMessage());
    //     }
    // }
}