@extends('layouts.user')

@section('content')
<div class="min-h-screen text-yellow-500 relative">
    <!-- Background -->
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/30 via-blue-900/30 to-black/90"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')] bg-cover bg-center opacity-20"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-center">
        <div class="w-full max-w-xl">

            <div class="card-bg rounded-2xl border border-gold/30 shadow-2xl glow-effect">

                <div class="text-center py-4 px-3 border-b border-gold/20">
                    <h2 class="text-3xl font-bold text-gold mb-2">NẠP THẺ</h2>
                    <p class="text-green-400 text-sm leading-relaxed">
                        Lưu ý: CHỌN ĐÚNG MỆNH GIÁ GHI TRÊN THẺ, CHỌN SAI MỆNH GIÁ SẼ<br>
                        MẤT THẺ VÀ KHÔNG HỖ TRỢ HOÀN TRẢ
                    </p>
                </div>

                <form action="" method="POST" class="p-6 ">
                    @csrf

                    <div class="mb-4">
                        <label for="server" class="block text-gray-300 text-sm font-medium mb-2">Máy chủ</label>
                        <select name="server" id="server"
                                class="w-full bg-gray-800/50 border border-gold/30 rounded-lg px-4 py-3 text-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all duration-200"
                                required>
                            <option value="s1" {{ old('server') == 's1' ? 'selected' : '' }}>[s1] Thánh Giống</option>
                            <option value="s2" {{ old('server') == 's2' ? 'selected' : '' }}>[s2] Thiên Long</option>
                            <option value="s3" {{ old('server') == 's3' ? 'selected' : '' }}>[s3] Minh Giáo</option>
                        </select>
                        @error('server')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="character" class="block text-gray-300 text-sm font-medium mb-2">Nhân vật</label>
                        <input type="text" name="character" id="character"
                               placeholder="Chưa có nhân vật. Vui lòng vào game tạo."
                               class="w-full bg-gray-800/50 border border-gold/30 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all duration-200"
                               value="{{ old('character') }}"
                               required>
                        @error('character')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="card_type" class="block text-gray-300 text-sm font-medium mb-2">Chọn loại thẻ</label>
                        <select name="card_type" id="card_type"
                                class="w-full bg-gray-800/50 border border-gold/30 rounded-lg px-4 py-3 text-white focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all duration-200"
                                required>
                            <option value="" {{ old('card_type') == '' ? 'selected' : '' }}>-- Chọn loại thẻ --</option>
                            <option value="viettel" {{ old('card_type') == 'viettel' ? 'selected' : '' }}>Viettel</option>
                            <option value="mobifone" {{ old('card_type') == 'mobifone' ? 'selected' : '' }}>Mobifone</option>
                            <option value="vinaphone" {{ old('card_type') == 'vinaphone' ? 'selected' : '' }}>Vinaphone</option>
                            <option value="vietnamobile" {{ old('card_type') == 'vietnamobile' ? 'selected' : '' }}>Vietnamobile</option>
                            <option value="gmobile" {{ old('card_type') == 'gmobile' ? 'selected' : '' }}>Gmobile</option>
                        </select>
                        @error('card_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="serial_number" class="block text-gray-300 text-sm font-medium mb-2">Số Serial:</label>
                        <input type="text" name="serial_number" id="serial_number"
                               placeholder="Số Serial:"
                               class="w-full bg-gray-800/50 border border-gold/30 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all duration-200"
                               value="{{ old('serial_number') }}"
                               required>
                        @error('serial_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="card_code" class="block text-gray-300 text-sm font-medium mb-2">Nhập mã thẻ:</label>
                        <input type="text" name="card_code" id="card_code"
                               placeholder="Nhập mã thẻ"
                               class="w-full bg-gray-800/50 border border-gold/30 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-gold focus:ring-2 focus:ring-gold/20 focus:outline-none transition-all duration-200"
                               value="{{ old('card_code') }}"
                               required>
                        @error('card_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-credit-card mr-2"></i>
                            Xác nhận
                        </button>
                    </div>
                </form>

                <div class="px-6 pb-6">
                    <div class="bg-blue-900/30 border border-blue-500/50 rounded-lg p-4">
                        <div class="flex items-center text-blue-300 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span>Hỗ trợ: Liên hệ admin nếu có vấn đề về nạp thẻ</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 text-center">
                <p class="text-gray-400 text-sm">
                    <i class="fas fa-shield-alt mr-1 text-gold"></i>
                    Hệ thống nạp thẻ tự động 24/7
                </p>
            </div>
        </div>
    </div>

    <style>
        .glow-effect {
            box-shadow: 0 0 20px rgba(255, 165, 0, 0.3);
        }
        .card-bg {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(30, 30, 30, 0.9) 100%);
            backdrop-filter: blur(10px);
        }
    </style>
</div>
@endsection