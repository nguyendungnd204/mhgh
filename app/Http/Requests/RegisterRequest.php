<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'account_name' => 'required|string|unique:users,account_name|max:255|regex:/^[a-zA-Z0-9_]+$/',
            'password' => 'required|confirmed|min:6',
            'role' => 'sometimes|in:admin,user'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'account_name.required' => 'Tên tài khoản là bắt buộc.',
            'account_name.unique' => 'Tên tài khoản đã tồn tại.',
            'account_name.regex' => 'Tên tài khoản chỉ được chứa chữ cái, số và dấu gạch dưới.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.in' => 'Vai trò không hợp lệ.'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->checkRateLimit();
        
        $this->merge([
            'name' => trim($this->name ?? ''),
            'account_name' => trim($this->account_name ?? ''),
        ]);
    }

    private function checkRateLimit(): void
    {
        $throttleKey = 'register.' . $this->ip();
        
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'account_name' => "Quá nhiều lần đăng ký. Vui lòng thử lại sau {$seconds} giây.",
            ]);
        }
    }

    public function failedValidation($validator): void
    {
        $throttleKey = 'register.' . $this->ip();
        RateLimiter::hit($throttleKey, 300);
        
        parent::failedValidation($validator);
    }
}