<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
    $rules = [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'cover_image' => ['required', 'image', 'max:2048'],
            'pinned' => ['required', 'boolean'],
            'tags' => ['array'],
            'tags.*' => ['exists:tags,id'],
        ];

        // لو العملية تحديث (PATCH أو PUT)، نسمح أن تكون الحقول "sometimes"
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['title'] = ['sometimes', 'required', 'string', 'max:255'];
            $rules['body'] = ['sometimes', 'required', 'string'];
            $rules['cover_image'] = ['nullable', 'image', 'max:2048'];
            $rules['pinned'] = ['sometimes', 'required', 'boolean'];
        }

        return $rules;
    }
}
