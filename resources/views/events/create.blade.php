@extends('layouts.admin')

@section('content')
    
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-md rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 text-xl font-semibold">
                Thêm sự kiện mới
            </div>
            <div class="p-6">
                <div id="form-errors" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"></div>
                <form id="event-form" action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @include('events.form')

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            Save
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#event-form');
        const errorDiv = document.getElementById('form-errors');

        if (!form) {
            console.warn('Form không được tìm thấy.');
            return;
        }

        const handleSubmit = function(e) {
            if (errorDiv) {
                errorDiv.classList.add('hidden');
                errorDiv.innerHTML = '';
            }

            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            if (!startDateInput || !endDateInput || !startDateInput.value || !endDateInput.value) {
                e.preventDefault();
                showError('Vui lòng chọn đầy đủ ngày bắt đầu và ngày kết thúc.');
                return;
            }

            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const today = new Date();

            if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                e.preventDefault();
                showError('Ngày không hợp lệ. Vui lòng kiểm tra lại.');
                return;
            }

            today.setHours(0, 0, 0, 0);
            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);

            const errors = [];

            if (startDate < today) {
                errors.push('Ngày bắt đầu không được trong quá khứ.');
            }
            if (endDate < today) {
                errors.push('Ngày kết thúc không được trong quá khứ.');
            }
            if (endDate < startDate) {
                errors.push('Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.');
            }

            if (errors.length > 0) {
                e.preventDefault();
                showError(errors.join('<br>'));
                return;
            }

            console.log('Form hợp lệ, đang submit...');
        };

        form.removeEventListener('submit', handleSubmit);
        form.addEventListener('submit', handleSubmit);

        function showError(message) {
            if (errorDiv) {
                errorDiv.innerHTML = message;
                errorDiv.classList.remove('hidden');
                errorDiv.scrollIntoView({ behavior: 'smooth' });
            } else {
                alert(message);
            }
        }
    });
</script>
@endpush