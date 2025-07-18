@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold mb-6">Chi tiết mã quà tặng</h2>



        <div class="bg-white shadow-md rounded-lg">
            <div class="p-6">
                <p class="mb-2"><strong class="font-semibold">Mã code: </strong>{{ $giftCode->code ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Vật phẩm: </strong>{{ $giftCode->reward ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Số lượng tối đa: </strong>{{ $giftCode->max_uses ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Số lượt đã sử dụng:
                    </strong>{{ $giftCode->used_count ?? '-' }}</p>
                <p class="mb-4"><strong class="font-semibold">Trạng thái: </strong>
                    <span
                        class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $giftCode->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $giftCode->is_active ? 'Còn hạn' : 'Hết hạn' }}
                    </span>
                </p>
                <p class="mb-2"><strong class="font-semibold">Thời gian tạo: </strong>{{ $giftCode->created_at ?? '-' }}
                </p>
                <p class="mb-2"><strong class="font-semibold">Thời gian hết hạn:
                    </strong>{{ $giftCode->expired_at ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Người chỉnh sửa cuối:
                    </strong>{{ $giftCode->creator->name ?? '-' }}</p>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-200 px-6 pb-6">
                <a href="{{ route('admin.giftcodes.index') }}"
                    class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                    Quay lại
                </a>
            </div>

        </div>
    </div>
    </div>
@endsection
