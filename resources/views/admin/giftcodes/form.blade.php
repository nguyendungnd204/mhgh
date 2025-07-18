<div class="mb-4">
    <label for="reward" class="block text-sm font-medium text-gray-700">Phần thưởng</label>
    <input type="text" name="reward" id="reward"
           value="{{ old('reward') }}"
           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    @error('reward')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="expired_at" class="block text-sm font-medium text-gray-700">Ngày hết hạn</label>
    <input type="datetime-local" name="expired_at" id="expired_at"
           value="{{ old('expired_at') }}"
           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    @error('expired_at')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="max_uses" class="block text-sm font-medium text-gray-700">Số lượt sử dụng tối đa</label>
    <input type="number" name="max_uses" id="max_uses"
           value="{{ old('max_uses') }}"
           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
           min="1" step="1"
           placeholder="Nhập số lượt sử dụng tối đa">
    @error('max_uses')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="is_active" class="block text-sm font-medium text-gray-700">Kích hoạt</label>
    <select name="is_active" id="is_active"
            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Hoạt động</option>
        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Khóa</option>
    </select>
    @error('is_active')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

