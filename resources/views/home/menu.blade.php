<div class="bg-gradient-to-br from-gray-900/90 via-purple-900/20 to-gray-900/90 backdrop-blur-lg border border-white/20 rounded-2xl p-6 md:p-8 shadow-2xl">
    <h2 class="text-2xl md:text-3xl font-bold text-yellow-400 mb-6 text-center">
        <i class="fas fa-newspaper mr-3"></i>
        TIN TỨC - SỰ KIỆN - HƯỚNG DẪN
    </h2>
    
    <div class="flex flex-wrap justify-center gap-2 md:gap-3 mb-6 md:mb-8">
        <button class="relative bg-gradient-to-r from-purple-600 via-blue-600 to-purple-700 hover:from-purple-700 hover:via-blue-700 hover:to-purple-800 px-3 py-2 md:px-4 md:py-2 rounded-lg font-semibold text-sm md:text-base hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-purple-500/25 active bg-yellow-400 text-black" 
                data-category="events"
                style="box-shadow: 0 4px 15px rgba(250, 204, 21, 0.4);">
            <i class="fas fa-calendar-alt mr-1 md:mr-2"></i> 
            SỰ KIỆN
        </button>
        <button class="relative bg-gradient-to-r from-purple-600 via-blue-600 to-purple-700 hover:from-purple-700 hover:via-blue-700 hover:to-purple-800 text-white px-3 py-2 md:px-4 md:py-2 rounded-lg font-semibold text-sm md:text-base hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-purple-500/25" 
                data-category="news">
            <i class="fas fa-newspaper mr-1 md:mr-2"></i> 
            TIN TỨC
        </button>
    </div>
    
    <div id="newsContainer" class="space-y-4">
        
        <div class="news-section events-section transition-opacity duration-500 ease-in-out">
            @forelse ($events as $item)
                <div class="news-item bg-gray-800/50 hover:bg-gray-800/70 rounded-lg p-4 border-l-4 border-yellow-400 transition-all duration-300 cursor-pointer transform hover:scale-[1.02] hover:shadow-lg mb-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <span class="text-yellow-400 font-semibold mb-2 md:mb-0 hover:text-yellow-300 transition-colors">{{ $item->title }}</span>
                        <span class="text-gray-400 text-sm flex items-center">
                            <i class="fas fa-calendar mr-1"></i> 
                            {{ $item->start_date->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="empty-state text-center py-8">
                    <i class="fas fa-calendar-times text-4xl text-gray-600 mb-4"></i>
                    <p class="text-gray-400">Chưa có sự kiện nào!</p>
                </div>
            @endforelse
            <div class="mt-4">
                {{ $events->withQueryString()->links() }}
            </div>
        </div>

        <div class="news-section hidden transition-opacity duration-500 ease-in-out">
            @forelse ($news as $item)
                <div class="news-item bg-gray-800/50 hover:bg-gray-800/70 rounded-lg p-4 border-l-4 border-yellow-400 transition-all duration-300 cursor-pointer transform hover:scale-[1.02] hover:shadow-lg mb-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <span class="text-yellow-400 font-semibold mb-2 md:mb-0 hover:text-yellow-300 transition-colors">{{ $item->title }}</span>
                        <span class="text-gray-400 text-sm flex items-center">
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
            <div class="mt-4">
                {{ $news->withQueryString()->links() }}
            </div>
        </div>
        
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryBtns = document.querySelectorAll('[data-category]');
    const newsSections = document.querySelectorAll('.news-section');

    console.log('Events count:', document.querySelectorAll('.events-section .news-item').length);
    console.log('News count:', document.querySelectorAll('.news-section:not(.events-section) .news-item').length);

    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            console.log('Switching to category:', category);
            
            if (this.classList.contains('category-btn-active')) {
                console.log('Already active, returning');
                return;
            }
            
            categoryBtns.forEach(b => {
                b.classList.remove('category-btn-active');
                b.classList.remove('bg-yellow-400', 'text-black');
                b.classList.add('bg-gradient-to-r', 'from-purple-600', 'via-blue-600', 'to-purple-700', 'text-white');
                b.style.boxShadow = '';
            });
            
            this.classList.add('category-btn-active');
            this.classList.add('bg-yellow-400', 'text-black');
            this.classList.remove('bg-gradient-to-r', 'from-purple-600', 'via-blue-600', 'to-purple-700', 'text-white');
            this.style.boxShadow = '0 4px 15px rgba(250, 204, 21, 0.4)';
            
            newsSections.forEach(section => {
                section.classList.add('hidden');
                section.style.opacity = '0';
            });
            
            setTimeout(() => {
                let targetSection;
                if (category === 'events') {
                    targetSection = document.querySelector('.events-section');
                } else if (category === 'news') {
                    targetSection = document.querySelector('.news-section:not(.events-section)');
                }
                
                console.log('Target section:', targetSection);
                if (targetSection) {
                    targetSection.classList.remove('hidden');
                    setTimeout(() => {
                        targetSection.style.opacity = '1';
                    }, 50);
                }
            }, 100);
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.news-item')) {
            const newsItem = e.target.closest('.news-item');
            

            newsItem.style.transform = 'scale(0.98)';
            setTimeout(() => {
                newsItem.style.transform = 'scale(1.02)';
            }, 150);
        }
    });
});
</script>