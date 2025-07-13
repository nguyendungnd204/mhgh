<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'required|boolean',
            'content_blocks' => 'nullable|array',
            'content_blocks.*.id' => 'nullable|exists:content_blocks,id',
            'content_blocks.*.content' => 'required_with:content_blocks|string',
            'content_blocks.*.order' => 'nullable|integer|min:1',
            'content_blocks.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content_blocks.*.existing_image' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'is_active.required' => 'Trạng thái hoạt động là bắt buộc.',
            'is_active.boolean' => 'Trạng thái hoạt động phải là true hoặc false.',
            'thumbnail.image' => 'Thumbnail phải là một hình ảnh.',
            'thumbnail.mimes' => 'Thumbnail phải có định dạng: jpeg, png, jpg, gif.',
            'thumbnail.max' => 'Thumbnail không được vượt quá 2MB.',
            'content_blocks.*.content.required_with' => 'Nội dung block là bắt buộc.',
            'content_blocks.*.image.image' => 'Hình ảnh block phải là một hình ảnh.',
            'content_blocks.*.image.mimes' => 'Hình ảnh block phải có định dạng: jpeg, png, jpg, gif.',
            'content_blocks.*.image.max' => 'Hình ảnh block không được vượt quá 2MB.',
            'content_blocks.*.id.exists' => 'Content block không tồn tại.',
        ];
    }
}