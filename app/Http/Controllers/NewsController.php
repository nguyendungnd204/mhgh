<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\NewsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NewsController extends Controller
{

    public function __construct(private NewsService $newsService)
    {
        /** @var \Illuminate\Routing\Controller $this */
        $this->middleware('can:view news')->only('index', 'show');
        $this->middleware('can:create news')->only('create', 'store');
        $this->middleware('can:edit news')->only('edit', 'update');
    }

    public function index(Request $request): View
    {
        if(!Auth::user()->can('view news'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $news = $this->newsService->getAllNews($request);

        return view('admin.news.index', compact('news'));
    }

    public function create(): View
    {
        if(!Auth::user()->can('create news'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        return view('admin.news.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        if(!Auth::user()->can('create news'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

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
        if(!Auth::user()->can('view news'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $news = $this->newsService->getNewsById($id);

        return view('admin.news.show', compact('news'));
    }

    public function edit(int $id): View 
    {
        if(!Auth::user()->can('edit news'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $news = $this->newsService->getNewsById($id);

        return view('admin.news.edit', compact('news'));
    }

    public function update(UpdateEventRequest $request, int $id): RedirectResponse
    {
        if(!Auth::user()->can('edit news'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }
        
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
