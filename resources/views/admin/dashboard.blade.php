@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Tổng người dùng</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $userCount ?? '' }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Tổng giao dịch</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $transactionCount ?? '' }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Tổng sự kiện</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $eventCount }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Tổng mã quà tặng</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $giftCount }}</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Giao dịch gần đây</h3>
                    <a href="{{ route('admin.transactions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Xem
                        tất cả</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Trạng thái</th>
                                <th class="py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Mã giao dịch
                                </th>
                                <th class="py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Loại thẻ</th>
                                <th class="py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Mệnh giá</th>
                                <th class="py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide text-right">
                                    Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($transactions) > 0)
                                @foreach ($transactions as $transaction)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="py-3">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                class="text-sm font-medium text-gray-800">{{ $transaction->card_code }}</span>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-sm text-gray-600">{{ $transaction->card_type }}</span>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-sm text-gray-600">{{ $transaction->amount }}</span>
                                        </td>
                                        <td class="py-3 text-right">
                                           @php
                                                $statusMap = [
                                                    'pending' => ['label' => 'Đang xử lý', 'class' => 'bg-yellow-100 text-yellow-800'],
                                                    'success' => ['label' => 'Thành công', 'class' => 'bg-green-100 text-green-800'],
                                                    'failed' => ['label' => 'Thất bại', 'class' => 'bg-red-100 text-red-800'],
                                                ];
                                                $status = $statusMap[$transaction->status] ?? ['label' => 'Không rõ', 'class' => 'bg-gray-100 text-gray-800'];
                                            @endphp

                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $status['class'] }}">
                                                {{ $status['label'] }}
                                            </span>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center px-2 py-1 text-gray-100">Không có giao dịch nào
                                    </td>
                                </tr>
                            @endif


                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Tin tức mới nhất</h3>
                    <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Xem tất
                        cả</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Tiêu đề</th>
                                <th class="py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Nội dung</th>
                                <th class="py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide text-right">Thời
                                    gian bắt đầu</th>
                                <th class="py-2 text-xs font-semibold text-gray-600 uppercase tracking-wide text-right">Thời
                                    gian kết thúc</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($events) > 0)
                                @foreach ($events as $event)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 font-semibold text-gray-800">{{ $event->title }}</td>
                                        <td class="px-4 py-2 text-gray-600">{{ Str::limit($event->description, 30) }}</td>
                                        <td class="px-4 py-2 text-right text-gray-500">
                                            {{ $event->start_date->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-2 text-right text-gray-500">
                                            {{ $event->end_date->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center px-2 py-1 text-gray-100">Không có sự kiện nào</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
