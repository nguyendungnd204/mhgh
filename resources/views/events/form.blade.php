<div class="mb-4">
    <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề sự kiện</label>
    <input type="text" name="title" id="title"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        value="{{ old('title') }}" required>
</div>

<div class="mb-4">
    <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
    <textarea name="description" id="description"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        rows="4" required>{{ old('description') }}</textarea>
</div>

<div class="mb-4">
    <label for="thumbnail" class="block text-sm font-medium text-gray-700">Ảnh đại diện</label>
    <input type="file" name="thumbnail" id="thumbnail"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

<div class="mb-4">
    <label for="start_date" class="block text-sm font-medium text-gray-700">Ngày bắt đầu</label>
    <input type="date" name="start_date" id="start_date"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        value="{{ old('start_date') }}" required>
</div>

<div class="mb-4">
    <label for="end_date" class="block text-sm font-medium text-gray-700">Ngày kết thúc</label>
    <input type="date" name="end_date" id="end_date"
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        value="{{ old('end_date') }}" required>
</div>

<hr class="my-6">

<h3 class="text-lg font-semibold mb-4">Danh sách nội dung </h3>

<div id="content-blocks-wrapper">

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
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700">Nội dung</label>
            <textarea name="content_blocks[0][content]" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- <div>
            <label class="block text-sm font-medium text-gray-700">Thứ tự</label>
            <input type="number" name="content_blocks[0][order]" value="1"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div> -->
    </div>
</div>

<button type="button" onclick="addContentBlock()"
    class="mb-6 bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md transition-colors">
    <i class="fas fa-plus"></i> Thêm nội dung
</button>

<script>
    let blockIndex = 0;

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
                }
            }
        });

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

        if (wrapper.querySelectorAll('.content-block').length <= 0) {
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
