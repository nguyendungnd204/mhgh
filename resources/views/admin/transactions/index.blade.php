@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-2 border-b border-gray-200">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="w-full md:w-auto mb-2 md:mb-0">
                        <h2 class="text-2xl font-bold text-gray-800">Danh sách giao dịch</h2>
                    </div>
                    <div class="w-full md:w-auto">
                        <div class="flex items-center gap-2">
                            <div class="w-full md:w-45">
                                <form class="flex gap-2" role="search" action="{{route('admin.transactions.index')}}" method="get">
                                    @csrf
                                    <input class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500" name="search" type="search" placeholder="mã code" aria-label="Search">
                                    <button class="px-2 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap" type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                            <div class="flex ">
                                <a href="" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-nowrap">Thêm mã quà tặng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="p-3 pt-5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 text-gray-700 font-semibold">ID</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Mã giao dịch</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Loại thẻ</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Mệnh giá</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Số serial</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Mã thẻ cào</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Tài khoản</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Máy chủ</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Tên nhân vật</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Thời gian tạo</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Trạng thái</th>
                                <th class="px-2 py-1 text-gray-700 font-semibold">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($transactions) > 0)
                                @foreach ($transactions as $transaction)
                                    <tr class="border-t border-gray-200 hover:bg-gray-200 cursor-pointer" onclick="window.location.href=">
                                        <th class="px-2 py-2 text-gray-800">{{ $transaction->id }}</th>
                                        <td class="px-2 py-2 text-gray-600">{{ $transaction->transaction_code ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $transaction->card_type ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $transaction->amount ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600 text-nowrap">{{ $transaction->serial ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600 text-nowrap">{{ $transaction->card_code ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $transaction->user->account_name }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $transaction->character->server_name ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $transaction->character->character_name ?? '' }}</td>
                                        <td class="px-2 py-2 text-gray-600">{{ $transaction->submitted_at ?? '' }}</td>
                                        @php
                                            $statusText = [
                                                'pending' => 'Đang xử lý',
                                                'success' => 'Thành công',
                                                'failed' => 'Thất bại',
                                            ];

                                            $statusColor = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'success' => 'bg-green-100 text-green-800',
                                                'failed' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp

                                        <td class="px-2 py-2 text-sm font-medium rounded {{ $statusColor[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusText[$transaction->status] ?? 'Không rõ' }}
                                        </td>

                                        <td class="px-2 py-2">
                                             <a href="" class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600 transition-colors text-nowrap">Chỉnh sửa</a>
                                        </td>
                            
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center px-2 py-1 text-gray-600">Chưa có giao dịch nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $transactions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection