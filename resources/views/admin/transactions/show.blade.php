@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold mb-6">Chi tiết giao dịch</h2>



        <div class="bg-white shadow-md rounded-lg">
            <div class="p-6">
                <p class="mb-2"><strong class="font-semibold">Mã giao dịch:
                    </strong>{{ $transaction->transaction_code ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Loại thẻ: </strong>{{ $transaction->card_type ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Mệnh giá: </strong>{{ $transaction->amount ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Số serial: </strong>{{ $transaction->serial ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Mã thẻ: </strong>{{ $transaction->card_code ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Tài khoản:
                    </strong>{{ $transaction->user->account_name ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Máy chủ:
                    </strong>{{ $transaction->character->server_name ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Tài khoản:
                    </strong>{{ $transaction->character->character_name ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Thời gian tạo:
                    </strong>{{ $transaction->created_at ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Thời gian xử lý:
                    </strong>{{ $transaction->verified_at ?? '-' }}</p>
                <p class="mb-2"><strong class="font-semibold">Trạng thái: </strong>
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
                    <span
                        class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusText[$transaction->status] ?? 'Không rõ' }}
                    </span>
                </p>

            </div>
            <div class="mt-6 pt-4 border-t border-gray-200 px-6 pb-6">
                <a href="{{ route('admin.transactions.index') }}"
                    class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                    Quay lại
                </a>
            </div>

        </div>
    </div>
@endsection
