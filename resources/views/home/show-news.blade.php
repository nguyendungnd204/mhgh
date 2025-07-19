@extends('layouts.guest')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="glass-effect rounded-2xl p-6 md:p-8 shadow-2xl">
        <h2 class="text-2xl md:text-3xl font-bold text-yellow-400 mb-2 text-center">
            <i class="fas fa-newspaper mr-3"></i>
            {{ $news->title ?? 'Chi tiết tin tức' }}
        </h2>

        <div class="text-center mb-6">
            <p class="text-sm md:text-base text-gray-300">
                <span class="font-semibold text-yellow-400">Từ:</span> {{ $news->start_date ? $news->start_date->format('d/m/Y') : '-' }}
                <span class="mx-2">|</span>
                <span class="font-semibold text-yellow-400">Đến:</span> {{ $news->end_date ? $news->end_date->format('d/m/Y') : '-' }}
            </p>
        </div>

        @if ($news->thumbnail)
            <div class="mb-6">
                <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title ?? 'News Thumbnail' }}" class="w-full h-auto rounded-lg shadow-md">
            </div>
        @endif

        <div class="bg-gray-800 bg-opacity-50 rounded-lg p-6 mb-6">
            <p class="mb-4">
                <span class="font-semibold text-yellow-400 block">Chi tiết:</span>
                <span class="text-gray-300">{{ $news->description ?? '-' }}</span>
            </p>
        </div>

        <div class="bg-gray-800 bg-opacity-50 rounded-lg p-6">
            @if(isset($news->contentBlocks) && $news->contentBlocks->count() > 0)
                @foreach($news->contentBlocks as $block)
                    @if($block->image)
                        <img src="{{ asset('storage/' . $block->image) }}" alt="Block Image" class="w-full h-auto rounded-lg mb-4">
                    @endif
                    <p class="text-gray-300 mb-4">{{ $block->content ?? '' }}</p>
                @endforeach
            @else
                <p ></p>
            @endif
        </div>
    </div>
</div>
@endsection