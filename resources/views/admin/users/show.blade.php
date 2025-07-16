@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold mb-6">Thông tin người dùng</h2>

    <div class="bg-white shadow-md rounded-lg">
        <div class="p-6">
            <p class="mb-2"><strong class="font-semibold">Tên người dùng: </strong>{{ $user->name ?? '-' }}</p>
            <p class="mb-2"><strong class="font-semibold">Tên tài khoản: </strong>{{ $user->account_name ?? '-' }}</p>
            <p class="mb-2"><strong class="font-semibold">Vai trò: </strong>{{ $user->role ?? '-' }}</p>
            <p class="mb-2"><strong class="font-semibold">Ngày tạo: </strong>{{ $user->created_at ?? '-' }}</p>
            <p class="mb-4"><strong class="font-semibold">Trạng thái: </strong>
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-500 text-white' }}">
                    {{ $user->is_active ? 'Hoạt động' : 'Đã khoá' }}
                </span>
            </p>
        </div>

        <div class="p-4 border-t border-gray-200">
            <a href="{{ route('admin.users.index') }}" class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">Quay lại</a>
        </div>
    </div>
</div>
</div>
</div>
@endsection