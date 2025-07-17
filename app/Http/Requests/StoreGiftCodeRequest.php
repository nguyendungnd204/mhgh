<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGiftCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:gift_codes,code|min:6|max:20',
            'reward' => 'required|string|max:255',
            'expired_at' => 'nullable|date|after_or_equal:today',
            'max_uses' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Mã code là bắt buộc.',
            'code.unique' => 'Mã code đã tồn tại.',
            'code.min' => 'Mã code phải có ít nhất 6 ký tự.',
            'code.max' => 'Mã code không vượt quá 20 ký tự.',
            'reward.required' => 'Phần thưởng là bắt buộc.',
            'expired_at.date' => 'Ngày hết hạn không hợp lệ.',
            'expired_at.after_or_equal' => 'Ngày hết hạn phải từ hôm nay trở đi.',
            'max_uses.integer' => 'Số lượt sử dụng phải là số.',
            'max_uses.min' => 'Số lượt sử dụng ít nhất là 1.',
            'max_uses.required' => 'Số lượt sử dụng là bắt buộc.',
        ];
    }
}
