<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventService
{
    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getAllEvents(Request $request)
    {
        $query = $this->eventRepository->getQueryWithRelations(['user', 'contentBlocks']);

        if ($request->filled('search')) {
            $query = $this->eventRepository->search($query, $request->search);
        }

        return $this->eventRepository->paginate($query, 10);
    }

    public function createEvent(array $data, Request $request): Event
    {
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->handleThumbnailUpload($request->file('thumbnail'));
        }

        $data['created_by'] = Auth::id();
        $event = $this->eventRepository->create($data);

        if (!empty($data['content_blocks'])) {
            $this->createContentBlocks($event, $data['content_blocks']);
        }

        return $event;
    }

    public function updateEvent(Event $event, array $data, Request $request): Event
    {
        $this->handleThumbnailUpdate($event, $data, $request);

        $data['created_by'] = Auth::id();

        $event = $this->eventRepository->update($event, $data);

        $this->handleContentBlocksUpdate($event, $data, $request);

        return $event;
    }

    public function getEventById(int $id): Event
    {
        return $this->eventRepository->findWithRelations($id, [
            'contentBlocks' => function ($query) {
                $query->orderBy('order', 'asc');
            },
            'user'
        ]);
    }

    public function deleteEvent(Event $event): bool
    {
        if ($event->thumbnail) {
            Storage::disk('public')->delete($event->thumbnail);
        }

        foreach ($event->contentBlocks as $block) {
            if ($block->image) {
                Storage::disk('public')->delete($block->image);
            }
        }

        return $this->eventRepository->delete($event);
    }

    private function handleThumbnailUpload($file): string
    {
        return $file->store('events', 'public');
    }

    private function handleThumbnailUpdate(Event $event, array &$data, Request $request): void
    {
        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail) {
                Storage::disk('public')->delete($event->thumbnail);
            }
            $data['thumbnail'] = $this->handleThumbnailUpload($request->file('thumbnail'));
        } else {
            $data['thumbnail'] = $event->thumbnail;
        }
    }

    private function createContentBlocks(Event $event, array $contentBlocks): void
    {
        foreach ($contentBlocks as $index => $block) {
            $imagePath = null;

            if (isset($block['image'])) {
                $imagePath = $block['image']->store('content_blocks', 'public');
            }

            $event->contentBlocks()->create([
                'parent_type' => Event::class,
                'parent_id' => $event->id,
                'content' => $block['content'],
                'order' => $block['order'] ?? $index + 1,
                'image' => $imagePath,
            ]);
        }
    }

    private function handleContentBlocksUpdate(Event $event, array $data, Request $request): void
    {

        if (!empty($data['content_blocks'])) {
            $existingBlockIds = $event->contentBlocks()
                ->where('parent_type', Event::class)
                ->where('parent_id', $event->id)
                ->pluck('id')
                ->toArray();

            $newBlockIds = [];

            foreach ($data['content_blocks'] as $index => $block) {
                $imagePath = null;

                if (isset($block['image']) && $request->hasFile("content_blocks.$index.image")) {
                    $imagePath = $request->file("content_blocks.$index.image")->store('content_blocks', 'public');
                }

                $blockData = [
                    'parent_type' => Event::class,
                    'parent_id' => $event->id,
                    'content' => $block['content'],
                    'order' => $block['order'] ?? $index + 1,
                ];

                if ($imagePath) {
                    $blockData['image'] = $imagePath;
                } elseif (isset($block['existing_image'])) {
                    $blockData['image'] = $block['existing_image'];
                } else {
                    $blockData['image'] = null;
                }

                if (isset($block['id']) && $block['id']) {
                    $contentBlock = $event->contentBlocks()
                        ->where('id', $block['id'])
                        ->where('parent_type', Event::class)
                        ->where('parent_id', $event->id)
                        ->first();

                    if ($contentBlock) {
                        if ($imagePath && $contentBlock->image) {
                            Storage::disk('public')->delete($contentBlock->image);
                        }

                        $contentBlock->update($blockData);
                        $newBlockIds[] = $contentBlock->id;
                    }
                } else {
                    $contentBlock = $event->contentBlocks()->create($blockData);
                    $newBlockIds[] = $contentBlock->id;
                }
            }

            $blocksToDelete = array_diff($existingBlockIds, $newBlockIds);
            $this->deleteContentBlocks($event, $blocksToDelete);
        } else {
            $this->deleteAllContentBlocks($event);
        }
    }

    private function deleteContentBlocks(Event $event, array $blockIds): void
    {
        foreach ($blockIds as $blockId) {
            $block = $event->contentBlocks()
                ->where('id', $blockId)
                ->where('parent_type', Event::class)
                ->where('parent_id', $event->id)
                ->first();

            if ($block) {
                if ($block->image) {
                    Storage::disk('public')->delete($block->image);
                }
                $block->delete();
            }
        }
    }

    private function deleteAllContentBlocks(Event $event): void
    {
        $contentBlocks = $event->contentBlocks()
            ->where('parent_type', Event::class)
            ->where('parent_id', $event->id)
            ->get();

        foreach ($contentBlocks as $block) {
            if ($block->image) {
                Storage::disk('public')->delete($block->image);
            }
            $block->delete();
        }
    }

    public function getUpcomingEvents(): Collection
    {
        return $this->eventRepository->getUpcomingEvents();
    }

    public function count(): int
    {
        return $this->eventRepository->count();
    }

    public function getActiveEvents(int $limit)
    {
        return $this->eventRepository->getEventsActive($limit);
    }


}
