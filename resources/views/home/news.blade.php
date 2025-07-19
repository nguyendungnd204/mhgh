@extends('layouts.guest')

@section('content')
<div class="glass-effect rounded-2xl p-6 md:p-8 shadow-2xl">
    <h2 class="text-2xl md:text-3xl font-bold text-yellow-400 mb-6 text-center">
        <i class="fas fa-newspaper mr-3"></i>
        TIN TỨC
    </h2>
    
    <div id="newsContainer" class="space-y-4">
        @forelse ($news as $item)
            <div class="news-item bg-gray-800 bg-opacity-50 rounded-lg p-4 border-l-4 border-yellow-400 hover:bg-opacity-70 transition-colors cursor-pointer" onclick="location.href='{{ route('news.show', $item->id) }}'">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex-1">
                        <span class="text-yellow-400 font-semibold mb-2 md:mb-0">{{ $item->title }}</span>
                        <p class="text-gray-400 text-sm mt-1 line-clamp-2">{{ $item->description ?? '' }}</p>
                    </div>
                    <span class="text-gray-400 text-sm mt-2 md:mt-0">
                        <i class="fas fa-calendar mr-1"></i> 
                        {{ $item->start_date->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        @empty
            <div class="empty-state text-center py-8">
                <i class="fas fa-newspaper text-4xl text-gray-600 mb-4"></i>
                <p class="text-gray-400">Chưa có tin tức nào!</p>
            </div>
        @endforelse
        <div class="mt-4 ">
            {{ $news->withQueryString()->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if (e.target.closest('.news-item')) {
            const newsItem = e.target.closest('.news-item');
            newsItem.classList.add('scale-95');
            setTimeout(() => {
                newsItem.classList.remove('scale-95');
            }, 150);
        }
    });
});
</script>
@endpush
@endsection