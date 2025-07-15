<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'server_name' => 'required|string|max:255',
            'character_name' => 'required|string|max:255',
            'card_type' => 'required|string|in:viettel,mobifone,vinaphone,vietnamobile,garena',
            'amount' => 'required|integer|in:10000,20000,50000,100000,200000,500000',
            'serial' => 'required|string|max:50',
            'card_code' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'server_name.required' => 'Vui lòng nhập tên máy chủ.',
            'character_name.required' => 'Vui lòng nhập tên nhân vật.',
            'card_type.in' => 'Loại thẻ không hợp lệ.',
            'amount.in' => 'Mệnh giá không hợp lệ.',
        ];
    }
}
