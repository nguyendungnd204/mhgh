<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGiftCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reward' => 'required|string|max:255',
            'expired_at' => 'required|date|after_or_equal:today', // Đổi từ expires_at thành expired_at
            'max_uses' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'reward.required' => 'Phần thưởng là bắt buộc.',
            'reward.string' => 'Phần thưởng phải là chuỗi ký tự.',
            'reward.max' => 'Phần thưởng không được vượt quá 255 ký tự.',
            'expired_at.required' => 'Ngày hết hạn là bắt buộc.',
            'expired_at.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',
            'expired_at.after_or_equal' => 'Ngày hết hạn phải từ hôm nay trở đi.',
            'max_uses.required' => 'Số lượt sử dụng là bắt buộc.',
            'max_uses.integer' => 'Số lượt sử dụng phải là một số nguyên.',
            'max_uses.min' => 'Số lượt sử dụng phải lớn hơn 0.',
            'is_active.required' => 'Trạng thái hoạt động là bắt buộc.',
            'is_active.boolean' => 'Trạng thái hoạt động phải là true hoặc false.',
        ];
    }
}