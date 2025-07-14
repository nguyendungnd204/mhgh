<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\NewsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{

    public function __construct(private NewsService $newsService){}

    public function index(Request $request): View
    {
        $news = $this->newsService->getAllNews($request);

        return view('admin.news.index', compact('news'));
    }

    public function create(): View
    {
        return view('admin.news.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        try {
            $this->newsService->createNews($request->validated(), $request);

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'Tạo tin tức mới thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error','Có lỗi khi tạo: '. $e->getMessage());
                            
        }
    }

    public function show(int $id): View 
    {
        $news = $this->newsService->getNewsById($id);

        return view('admin.news.show', compact('news'));
    }

    public function edit(int $id): View 
    {
        $news = $this->newsService->getNewsById($id);

        return view('admin.news.edit', compact('news'));
    }

    public function update(UpdateEventRequest $request, int $id): RedirectResponse
    {
        $news = $this->newsService->getNewsById($id);

        try {
            $this->newsService->updateNews($news, $request->validated(), $request);
            
            return redirect()->route('admin.news.index')
                           ->with('success', 'Cập nhật sự kiện thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

}
