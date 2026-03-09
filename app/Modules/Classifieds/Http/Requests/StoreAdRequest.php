<?php

namespace App\Modules\Classifieds\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],

            'title' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_type' => ['nullable', 'in:fixed,negotiable,call'],
            'condition_type' => ['nullable', 'in:new,used'],
            'location' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],

            'images' => ['nullable', 'array', 'max:' . config('classifieds.max_images', 5)],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}