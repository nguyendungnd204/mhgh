@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold mb-6">Chỉnh sửa mã quà tặng</h2>

    <div class="bg-white shadow-md rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.giftcodes.update', $giftCode->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-gray-700">Mã quà tặng</label>
                    <div class="flex space-x-2">
                        <input type="text" id="code" name="code" readonly
                               value="{{ old('code', $giftCode->code ?? '') }}"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-800"
                               placeholder="Nhấn 'Tạo mã'" required /> 
                    </div>
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="reward" class="block text-sm font-medium text-gray-700">Phần thưởng</label>
                    <input type="text" name="reward" id="reward"
                           value="{{ old('reward', $giftCode->reward ?? '') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           >
                    @error('reward')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="expired_at" class="block text-sm font-medium text-gray-700">Ngày hết hạn</label>
                    <input type="datetime-local" name="expired_at" id="expired_at"
                           value="{{ old('expired_at', optional($giftCode->expired_at)->format('Y-m-d\TH:i')) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('expired_at')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="max_uses" class="block text-sm font-medium text-gray-700">Số lượt sử dụng tối đa</label>
                    <input type="number" name="max_uses" id="max_uses"
                           value="{{ old('max_uses', $giftCode->max_uses ?? '') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           min="1" step="1"
                           placeholder="Nhập số lượt sử dụng tối đa" >
                    @error('max_uses')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Kích hoạt</label>
                    <select name="is_active" id="is_active"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" >
                        <option value="1" {{ old('is_active', $giftCode->is_active ?? 1) == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('is_active', $giftCode->is_active ?? 0) == 0 ? 'selected' : '' }}>Khóa</option>
                    </select>
                    @error('is_active')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.giftcodes.index') }}" class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">Quay lại</a>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection