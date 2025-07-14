<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_name' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'account_name.required' => 'Tên tài khoản là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->checkRateLimit();
        
        $this->merge([
            'account_name' => trim($this->account_name ?? ''),
        ]);
    }

    private function checkRateLimit(): void
    {
        $throttleKey = 'login.' . $this->ip();
        
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'account_name' => "Quá nhiều lần đăng nhập thất bại. Vui lòng thử lại sau {$seconds} giây.",
            ]);
        }
    }
}