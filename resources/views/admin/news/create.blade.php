@extends('layouts.admin')

@section('content')
    
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-md rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 text-xl font-semibold">
                Thêm tin tức mới
            </div>
            <div class="p-6">
                <div id="form-errors" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"></div>
                <form id="event-form" action="{{route('admin.news.store')}}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @include('admin.events.form')

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            Tạo
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                            Trở về
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection