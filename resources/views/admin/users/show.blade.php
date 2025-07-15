@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold mb-6">Thông tin người dùng</h2>
    
    <div class="bg-white shadow-md rounded-lg">
        <div class="p-6">
            <p class="mb-2"><strong class="font-semibold">Tên người dùng: </strong>{{ $user->name ?? '-' }}</p>
            <p class="mb-2"><strong class="font-semibold">Tên tài khoản </strong>{{ $user->account_name ?? '-' }}</p>
            <p class="mb-2"><strong class="font-semibold">Ngày bắt đầu: </strong>{{ $user->start_date ?? '-' }}</p>
            <p class="mb-2"><strong class="font-semibold">Ngày kết thúc: </strong>{{ $user->end_date ?? '-' }}</p>
            <p class="mb-2"><strong class="font-semibold">Người tạo: </strong>{{ optional($user->user)->name ?? '-' }}</p>
            <p class="mb-4"><strong class="font-semibold">Trạng thái: </strong>
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $user->is_active ? 'Hoạt động' : 'Ngừng hoạt động' }}
                </span>
            </p>
        </div>
        
        <!-- Content Blocks Section -->
        <div class="border-t border-gray-200">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-4">Nội dung phụ:</h3>
                
                @if(isset($user->contentBlocks) && $user->contentBlocks->count() > 0)
                    @foreach($user->contentBlocks as $block)
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            @if($block->image)
                                <img src="{{ asset('storage/' . $block->image) }}" alt="Block Image" class="w-32 h-auto mb-2 rounded">
                            @endif
                            
                            <p class="mb-2"><strong class="font-semibold">Nội dung: </strong>{{ $block->content ?? '-' }}</p>
                            <p class="mb-2"><strong class="font-semibold">Thứ tự: </strong>{{ $block->order ?? '-' }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-600">Không có nội dung phụ.</p>
                @endif

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.user.index') }}" class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection