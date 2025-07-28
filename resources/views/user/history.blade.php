@extends('layouts.user')

@section('content')
@can('view transactions user')
<div class="min-h-screen text-yellow-500 relative">
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/30 via-blue-900/30 to-black/90"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')] bg-cover bg-center opacity-20"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-center">
        <div class="w-full max-w-3xl">
            <div class="card-bg rounded-2xl border border-gold/30 shadow-2xl glow-effect">
                <div class="text-center py-4 px-3 border-b border-gold/20">
                    <h2 class="text-3xl font-bold text-gold mb-2">LỊCH SỬ GIAO DỊCH</h2>
                    <p class="text-green-400 text-sm leading-relaxed">
                        Xem lại lịch sử nạp thẻ của bạn
                    </p>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-white">
                            <thead>
                                <tr class="bg-gray-800/50 border-b border-gold/20">
                                    <th class="py-2 px-4 text-left text-sm font-medium">Máy chủ</th>
                                    <th class="py-2 px-4 text-left text-sm font-medium">Nhân vật</th>
                                    <th class="py-2 px-4 text-left text-sm font-medium">Loại thẻ</th>
                                    <th class="py-2 px-4 text-left text-sm font-medium">Số Serial</th>
                                    <th class="py-2 px-4 text-left text-sm font-medium">Mã thẻ</th>
                                    <th class="py-2 px-4 text-left text-sm font-medium">Thời gian</th>
                                    <th class="py-2 px-4 text-left text-sm font-medium">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($transactions) > 0)
                                    @foreach($transactions as $transaction)
                                        <tr class="border-b border-gold/20 hover:bg-gray-800/70 transition-colors">
                                            <td class="py-2 px-4">{{$transaction->character->server_name}}</td>
                                            <td class="py-2 px-4">{{$transaction->character->character_name}}</td>
                                            <td class="py-2 px-4">{{$transaction->card_type}}</td>
                                            <td class="py-2 px-4">{{$transaction->serial}}</td>
                                            <td class="py-2 px-4">{{$transaction->card_code}}</td>
                                            <td class="py-2 px-4">{{$transaction->submitted_at}}</td>
                                            <td class="py-2 px-4 text-green-400">
                                                {{ 
                                                    [
                                                        'pending' => 'Đang xử lý',
                                                        'success' => 'Thành công',
                                                        'failed' => 'Thất bại'
                                                    ] [$transaction->status] ?? 'Không rõ'
                                                }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center px-2 py-1 text-gray-100">Bạn chưa có giao dịch nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 pb-6 mt-6">
                        <div class="bg-blue-900/30 border border-blue-500/50 rounded-lg p-4">
                            <div class="flex items-center text-blue-300 text-sm">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>Liên hệ admin nếu cần hỗ trợ về lịch sử giao dịch</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-400 text-sm">
                    <i class="fas fa-shield-alt mr-1 text-gold"></i>
                    Hệ thống lưu trữ giao dịch an toàn 24/7
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
@endcan
@endsection