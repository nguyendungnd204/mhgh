<div class="mb-4">
    <label for="code" class="block text-sm font-medium text-gray-700">Mã quà tặng</label>
    <div class="flex space-x-2">
        <input type="text" id="code" name="code" readonly
               value="{{ old('code') }}"
               class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-800"
               placeholder="Nhấn 'Tạo mã'" />
        <button type="button" id="generateCodeBtn"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Tạo mã
        </button>
    </div>
    @error('code')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

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

<script>
   document.getElementById('generateCodeBtn').addEventListener('click', function () {
    const button = this;
    const codeInput = document.getElementById('code');
    
    button.disabled = true;
    button.textContent = 'Đang tạo...';
    
    fetch('{{ route('admin.giftcodes.generate') }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.code) {
            codeInput.value = data.code;
        } else if (data.error) {
            throw new Error(data.error);
        } else {
            throw new Error('Không nhận được mã code');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi khi tạo mã: ' + error.message);
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = 'Tạo mã';
    });
});
</script>