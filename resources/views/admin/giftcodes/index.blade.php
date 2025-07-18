@extends('layouts.admin')
@section('content')
    <div class="container  ">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-2 border-b border-gray-200">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="w-full md:w-auto mb-2 md:mb-0">
                        <h2 class="text-2xl font-bold text-gray-800">Danh sách mã quà tặng</h2>
                    </div>
                    <div class="w-full md:w-auto">
                        <div class="flex items-center gap-2">
                            <div class="w-full md:w-45">
                                <form class="flex gap-2" role="search" action="{{route('admin.giftcodes.index')}}" method="get">
                                    @csrf
                                    <input class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500" name="search" type="search" placeholder="mã code" aria-label="Search">
                                    <button class="px-2 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                            <div class="flex ">
                                <a href="{{ route('admin.giftcodes.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap">Thêm mã quà tặng</a>
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
                                <th class="px-2 py-1 text-gray-700 font-semibold">Mã code</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Vật phẩm</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Tối đa</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Đã sử dụng</th>
                                  <th class="px-2 py-1 text-gray-700 font-semibold">Còn lại</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Trạng thái</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Thời gian tạo</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Thời gian hết hạn</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Người chỉnh sửa cuối</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($giftCodes) > 0)
                                @foreach ($giftCodes as $giftCode)
                                    <tr class="border-t border-gray-200 hover:bg-gray-200 cursor-pointer" onclick="window.location.href='{{route('admin.giftcodes.show', $giftCode->id)}}'">
                                        <th class="px-2 py-2 text-gray-800">{{ $giftCode->id }}</th>
                                        <td class="px-2 py-2 text-gray-600">{{ $giftCode->code ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $giftCode->reward ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $giftCode->max_uses ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $giftCode->used_count ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ isset($giftCode->max_uses, $giftCode->used_count) ? $giftCode->max_uses - $giftCode->used_count : '' }}</td>
                                        <td class="px-2 py-2 text-gray-600 {{ $giftCode->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $giftCode->is_active ? 'Còn hạn' : 'Hết hạn' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $giftCode->created_at ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $giftCode->expired_at ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $giftCode->creator->name ?? '' }}</td>
                                        <td class="px-2 py-2">
                                             <a href="{{ route('admin.giftcodes.edit', $giftCode->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600 transition-colors text-nowrap">Chỉnh sửa</a>
                                        </td>
                            
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center px-2 py-1 text-gray-600">Chưa có sự mã quà tặng nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $giftCodes->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection