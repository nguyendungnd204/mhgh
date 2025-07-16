@extends('layouts.admin')
@section('content')
    <div class="container mx-auto px-4 ">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-2 py-2 border-b border-gray-200">
                <div class="flex flex-wrap users-center justify-between">
                    <div class="w-full md:w-auto mb-4 md:mb-0">
                        <h2 class="text-2xl font-bold text-gray-800">Danh sách người dùng</h2>
                    </div>
                    <div class="w-full md:w-auto">
                        <div class="flex users-center gap-4">
                            <div class="w-full md:w-45">
                                <form class="flex gap-2" role="search" action="{{ route('admin.users.index') }}"
                                    method="get">
                                    @csrf
                                    <input
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                        name="search" type="search" placeholder="Nhập tên, tên tài khoản"
                                        aria-label="Search">
                                    <button
                                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap"
                                        type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                            <div class="flex ">
                                <a href="{{ route('admin.users.index') }}"
                                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap">Thêm
                                    quản trị viên</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-2 text-gray-700 font-semibold">ID</th>
                                <th class="px-2 py-2 text-gray-700 font-semibold">Tên</th>
                                <th class="px-2 py-2 text-gray-700 font-semibold">Tên tài khoản</th>
                                <th class="px-2 py-2 text-gray-700 font-semibold">Vai trò</th>
                                <th class="px-2 py-2 text-gray-700 font-semibold">Trạng thái</th>
                                <th class="px-2 py-2 text-gray-700 font-semibold">Thời gian tạo</th>
                                <th class="px-2 py-2 text-gray-700 font-semibold">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($users) > 0)
                                @foreach ($users as $user)
                                    <tr class="border-t border-gray-200 hover:bg-gray-200 cursor-pointer"
                                        onclick="window.location.href='{{ route('admin.users.show', $user->id) }}'">
                                        <th class="px-2 py-2 text-gray-800">{{ $user->id }}</th>
                                        <td class="px-2 py-2 text-gray-600">{{ $user->name ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $user->account_name ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $user->role ?? '' }}</td>
                                        <td
                                            class="px-2 py-2 text-gray-600 {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-500 text-gray-800' }}">
                                            {{ $user->is_active ? 'Hoạt động' : 'Đã khoá' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $user->created_at ?? '' }}</td>
                                        <td class="px-2 py-2">
                                            <form action="{{ route('admin.users.updateStatus', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-700 transition-colors text-nowrap">
                                                    Khoá tài khoản
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center px-4 py-3 text-gray-600">Chưa có người dùng nào
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
