@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold mb-6">Chỉnh sửa sự kiện</h2>

    <div class="bg-white shadow-md rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề sự kiện</label>
                    <input type="text" name="title" id="title"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('title', $event->title ?? '') }}" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                    <textarea name="description" id="description"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="4" required>{{ old('description', $event->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700">Ảnh đại diện</label>
                    @if ($event->thumbnail)
                        <img src="{{ asset('storage/' . $event->thumbnail) }}" alt="{{ $event->title ?? 'Thumbnail' }}" class="w-32 h-auto mb-2 rounded">
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('thumbnail')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('start_date', $event->start_date ?? '') }}" required>
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('end_date', $event->end_date ?? '') }}" required>
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Trạng thái</label>
                    <select name="is_active" id="is_active"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="1" {{ old('is_active', $event->is_active) ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('is_active', $event->is_active) == 0 ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                    @error('is_active')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-6">

                <h3 class="text-lg font-semibold mb-4">Danh sách nội dung</h3>

                <div id="content-blocks-wrapper">
                    @if(isset($event->contentBlocks) && $event->contentBlocks->count() > 0)
                        @foreach($event->contentBlocks as $index => $block)
                            <div class="content-block mb-6 border border-gray-300 rounded-lg p-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="text-md font-medium text-gray-800">Nội dung #{{ $index + 1 }}</h4>
                                    <button type="button" onclick="removeContentBlock(this)" class="text-red-500 hover:text-red-700 text-sm">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </div>

                                <input type="hidden" name="content_blocks[{{ $index }}][id]" value="{{ $block->id }}">

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Ảnh minh họa</label>
                                    @if($block->image)
                                        <img src="{{ asset('storage/' . $block->image) }}" alt="Block Image" class="w-32 h-auto mb-2 rounded">
                                        <input type="hidden" name="content_blocks[{{ $index }}][existing_image]" value="{{ $block->image }}">
                                    @endif
                                    <input type="file" name="content_blocks[{{ $index }}][image]"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error("content_blocks.{$index}.image")
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Nội dung</label>
                                    <textarea name="content_blocks[{{ $index }}][content]" rows="3"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old("content_blocks.{$index}.content", $block->content ?? '') }}</textarea>
                                    @error("content_blocks.{$index}.content")
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Thứ tự</label>
                                    <input type="number" name="content_blocks[{{ $index }}][order]"
                                        value="{{ old("content_blocks.{$index}.order", $block->order ?? ($index + 1)) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error("content_blocks.{$index}.order")
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="content-block mb-6 border border-gray-300 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-md font-medium text-gray-800">Nội dung #1</h4>
                                <button type="button" onclick="removeContentBlock(this)" class="text-red-500 hover:text-red-700 text-sm">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </div>

                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700">Ảnh minh họa</label>
                                <input type="file" name="content_blocks[0][image]"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('content_blocks.0.image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700">Nội dung</label>
                                <textarea name="content_blocks[0][content]" rows="3"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content_blocks.0.content') }}</textarea>
                                @error('content_blocks.0.content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Thứ tự</label>
                                <input type="number" name="content_blocks[0][order]" value="{{ old('content_blocks.0.order', 1) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('content_blocks.0.order')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>

                <button type="button" onclick="addContentBlock()"
                    class="mb-6 bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md transition-colors">
                    <i class="fas fa-plus"></i> Thêm nội dung
                </button>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.events.index') }}" class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">Quay lại</a>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let blockIndex = {{ isset($event->contentBlocks) && $event->contentBlocks->count() > 0 ? $event->contentBlocks->count() : 1 }};

    function addContentBlock() {
        const wrapper = document.getElementById('content-blocks-wrapper');
        const firstBlock = wrapper.querySelector('.content-block');

        if (!firstBlock) {
            console.error('Không tìm thấy block mẫu');
            return;
        }

        const newBlock = firstBlock.cloneNode(true);

        const title = newBlock.querySelector('h4');
        if (title) {
            title.textContent = `Nội dung #${blockIndex + 1}`;
        }

        newBlock.querySelectorAll('input, textarea').forEach(el => {
            const name = el.getAttribute('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${blockIndex}]`);
                el.setAttribute('name', newName);

                if (el.type === 'file') {
                    el.value = '';
                } else if (el.tagName.toLowerCase() === 'textarea') {
                    el.value = '';
                } else if (el.type === 'number') {
                    el.value = blockIndex + 1;
                } else if (el.type === 'hidden' && el.name.includes('[id]')) {
                    el.remove(); // Remove ID field for new blocks
                }
            }
        });

        newBlock.querySelectorAll('img').forEach(img => img.remove()); // Remove preview images
        newBlock.querySelectorAll('input[name*="[existing_image]"]').forEach(input => input.remove()); // Remove existing image hidden input

        wrapper.appendChild(newBlock);
        blockIndex++;

        newBlock.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }

    function removeContentBlock(button) {
        const block = button.closest('.content-block');
        const wrapper = document.getElementById('content-blocks-wrapper');

        if (wrapper.querySelectorAll('.content-block').length <= 1) {
            alert('Phải có ít nhất 1 nội dung');
            return;
        }

        if (confirm('Bạn có chắc chắn muốn xóa nội dung này?')) {
            block.remove();
            updateBlockTitles();
        }
    }

    function updateBlockTitles() {
        const blocks = document.querySelectorAll('.content-block');
        blocks.forEach((block, index) => {
            const title = block.querySelector('h4');
            if (title) {
                title.textContent = `Nội dung #${index + 1}`;
            }
        });
    }
</script>
@endsection