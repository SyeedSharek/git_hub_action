<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . ($this->category->id ?? ''),
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'status' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->slug) {
            $this->merge([
                'slug' => Str::slug($this->name),
            ]);
        }
    }
}
