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

    public function createContentBlocks(News $event, array $contentBlocks):void 
    {
        foreach ($contentBlocks as $index => $block) 
        {
            $imagePath = null;

            if(isset($block['image']))
            {
                $imagePath = $block['image']->store('content_blocks', 'public');
            }

            $event->contentBlocks()->create([
                'parent_type' => News::class,
                'parent_id' => $event->id,
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
}
