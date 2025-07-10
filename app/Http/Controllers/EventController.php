<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['user', 'contentBlocks']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $events = $query->latest()->paginate(3);
        //dd($events->items());
        return view('events.index', compact('events'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'content_blocks' => 'nullable|array',
            'content_blocks.*.content' => 'required|string',
            'content_blocks.*.order' => 'nullable|integer',
            'content_blocks.*.image' => 'nullable|image',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('events', 'public');
        }

        $data['created_by'] = Auth::id();
        $event = Event::create($data);

        // Xử lý content_blocks (nếu có)
        if (!empty($data['content_blocks'])) {
            foreach ($data['content_blocks'] as $block) {
                $imagePath = null;

                if (isset($block['image'])) {
                    $imagePath = $block['image']->store('content_blocks', 'public');
                }

                $event->contentBlocks()->create([
                    'content' => $block['content'],
                    'order' => $block['order'] ?? 0,
                    'image' => $imagePath,
                ]);
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully');
    }

    public function create()
    {
        return view('events.create');
    }
}
