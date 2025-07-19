<?php

namespace App\Services;

use App\Models\News;
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

    public function createNews(array $data, Request $request): News
    {
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->handleThumbnailUpload($request->file('thumbnail'));
        }

        $data["created_by"]= Auth::id();

        $news = $this->newsRepository->create($data);

        if(!empty($data['content_blocks'])){
            $this->createContentBlocks($news, $data['content_blocks']);
        }

        return $news;
    }

    public function handleThumbnailUpload($file): string 
    {
        return $file->store('news', 'public');
    }

    public function createContentBlocks(News $news, array $contentBlocks):void 
    {
        foreach ($contentBlocks as $index => $block) 
        {
            $imagePath = null;

            if(isset($block['image']))
            {
                $imagePath = $block['image']->store('content_blocks', 'public');
            }

            $news->contentBlocks()->create([
                'parent_type' => News::class,
                'parent_id' => $news->id,
                'content' => $block['content'],
                'order' => $block['order'] ?? $index + 1,
                'image' => $imagePath,
            ]);
        }

        
    }

    public function getNewsById(int $id): News
    {
        return $this->newsRepository->findWithRelations($id, [
            'contentBlocks' => function ($query) {
                $query->orderBy('order', 'asc');
            },
            'user'
        ]);
    }

    public function updateNews(News $news, array $data, Request $request): News
    {
        $this->handleThumbnailUpdate($news, $data, $request);

        $data['created_by'] = Auth::id();

        $news = $this->newsRepository->update($news, $data);

        $this->handleContentBlocksUpdate($news, $data, $request);

        return $news;
    }


    private function handleThumbnailUpdate(News $news, array &$data, Request $request): void
    {
        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $data['thumbnail'] = $this->handleThumbnailUpload($request->file('thumbnail'));
        } else {
            $data['thumbnail'] = $news->thumbnail;
        }
    }


    private function handleContentBlocksUpdate(News $news, array $data, Request $request): void
    {

        if (!empty($data['content_blocks'])) {
            $existingBlockIds = $news->contentBlocks()
                ->where('parent_type', News::class)
                ->where('parent_id', $news->id)
                ->pluck('id')
                ->toArray();

            $newBlockIds = [];

            foreach ($data['content_blocks'] as $index => $block) {
                $imagePath = null;

                if (isset($block['image']) && $request->hasFile("content_blocks.$index.image")) {
                    $imagePath = $request->file("content_blocks.$index.image")->store('content_blocks', 'public');
                }

                $blockData = [
                    'parent_type' => News::class,
                    'parent_id' => $news->id,
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
                    $contentBlock = $news->contentBlocks()
                        ->where('id', $block['id'])
                        ->where('parent_type', News::class)
                        ->where('parent_id', $news->id)
                        ->first();

                    if ($contentBlock) {
                        if ($imagePath && $contentBlock->image) {
                            Storage::disk('public')->delete($contentBlock->image);
                        }

                        $contentBlock->update($blockData);
                        $newBlockIds[] = $contentBlock->id;
                    }
                } else {
                    $contentBlock = $news->contentBlocks()->create($blockData);
                    $newBlockIds[] = $contentBlock->id;
                }
            }

            $blocksToDelete = array_diff($existingBlockIds, $newBlockIds);
            $this->deleteContentBlocks($news, $blocksToDelete);
        } else {
            $this->deleteAllContentBlocks($news);
        }
    }

    private function deleteContentBlocks(News $news, array $blockIds): void
    {
        foreach ($blockIds as $blockId) {
            $block = $news->contentBlocks()
                ->where('id', $blockId)
                ->where('parent_type', News::class)
                ->where('parent_id', $news->id)
                ->first();

            if ($block) {
                if ($block->image) {
                    Storage::disk('public')->delete($block->image);
                }
                $block->delete();
            }
        }
    }

    private function deleteAllContentBlocks(News $news): void
    {
        $contentBlocks = $news->contentBlocks()
            ->where('parent_type', News::class)
            ->where('parent_id', $news->id)
            ->get();

        foreach ($contentBlocks as $block) {
            if ($block->image) {
                Storage::disk('public')->delete($block->image);
            }
            $block->delete();
        }
    }

    public function count(): int
    {
        return $this->newsRepository->count();
    }
}
