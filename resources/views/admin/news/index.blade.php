@extends('layouts.admin')
@section('content')
@can('view news')
    <div class="container  ">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-2 border-b border-gray-200">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="w-full md:w-auto mb-2 md:mb-0">
                        <h2 class="text-2xl font-bold text-gray-800">Danh sách tin tức</h2>
                    </div>
                    <div class="w-full md:w-auto">
                        <div class="flex items-center gap-2">
                            <div class="w-full md:w-45">
                                <form class="flex gap-2" role="search" action="{{route('admin.news.index')}}" method="get">
                                    @csrf
                                    <input class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" name="search" type="search" placeholder="Tên, Mô tả" aria-label="Search">
                                    <button class="px-2 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                            <div class="flex ">
                                @can('create news')
                                <a href="{{route('admin.news.create')}}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap">Thêm tin tức</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="p-3 pt-5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 text-gray-700 font-semibold">ID</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Tiêu đề</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Mô tả</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Ngày bắt đầu</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Ngày kết thúc</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Trạng thái</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Thời gian tạo</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Người chỉnh sửa cuối</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($news) > 0)
                                @foreach ($news as $item)
                                    <tr class="border-t border-gray-200 hover:bg-gray-200 cursor-pointer" onclick="window.location.href='{{ route('admin.news.show', $item->id) }}'">
                                        <th class="px-2 py-2 text-gray-800">{{ $item->id }}</th>
                                        <td class="px-2 py-2 text-gray-600">{{ $item->title ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $item->description ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $item->start_date ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $item->end_date ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600 {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $item->is_active ? 'Hoạt động' : 'Ngừng hoạt động' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $item->created_at ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $item->user->name ?? '' }}</td>
                                        <td class="px-2 py-2">
                                            @can('edit news')
                                             <a href="{{ route('admin.news.edit', $item->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600 transition-colors text-nowrap">Chỉnh sửa</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center px-4 py-3 text-gray-600">Chưa có tin tức nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $news->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endcan
@endsection