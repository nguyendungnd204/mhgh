<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateStatusTransactionRequest extends FormRequest
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
            'status' => 'required|string|in:pending,success,failed', // Example statuses
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.string' => 'Trạng thái phải là một chuỗi.',
            'status.in' => 'Trạng thái không hợp lệ. Chỉ chấp nhận pending, success, hoặc failed.',
        ];
    }
}
