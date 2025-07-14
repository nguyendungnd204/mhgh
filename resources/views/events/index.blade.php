@extends('layouts.admin')
@section('content')
    <div class="container mx-auto px-2 ">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-2 border-b border-gray-200">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="w-full md:w-auto mb-2 md:mb-0">
                        <h2 class="text-2xl font-bold text-gray-800">Danh sách sự kiện</h2>
                    </div>
                    <div class="w-full md:w-auto">
                        <div class="flex items-center gap-2">
                            <div class="w-full md:w-45">
                                <form class="flex gap-1" role="search" action="{{route('admin.events.index')}}" method="get">
                                    @csrf
                                    <input class="flex-1 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500" name="search" type="search" placeholder="Search" aria-label="Search">
                                    <button class="px-2 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                            <div class="flex ">
                                <a href="{{route('admin.events.create')}}" class="px-2 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap">Thêm sự kiện</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- @if (Session::has('success'))
                <div class="text-center bg-green-100 text-green-800 p-2 m-2 rounded-md">{{Session::get('success')}}</div>
            @endif
            @if (Session::has('error'))
                <div class="text-center bg-red-100 text-red-800 p-2 m-2 rounded-md">{{Session::get('error')}}</div>
            @endif -->
            
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
                            @if (count($events) > 0)
                                @foreach ($events as $event)
                                    <tr class="border-t border-gray-200 hover:bg-gray-200 cursor-pointer" onclick="window.location.href='{{ route('admin.events.show', $event->id) }}'">
                                        <th class="px-2 py-2 text-gray-800">{{ $event->id }}</th>
                                        <td class="px-2 py-2 text-gray-600">{{ $event->title ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $event->description ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $event->start_date ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $event->end_date ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600 {{ $event->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $event->is_active ? 'Hoạt động' : 'Ngừng hoạt động' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $event->created_at ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $event->user->name ?? '' }}</td>
                                        <td class="px-2 py-2">
                                             <a href="{{ route('admin.events.edit', $event->id) }}" class="px-1 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600 transition-colors text-nowrap">Chỉnh sửa</a>
                                        </td>
                                        <td class="px-2 py-2">
                                            {{-- <form action="{{route('product.destroy', $product->id)}}" method="post" class="inline-block">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="px-1 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 transition-colors" onclick="return confirm('Are you sure')">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center px-2 py-1 text-gray-600">Chưa có sự kiện nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $events->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection