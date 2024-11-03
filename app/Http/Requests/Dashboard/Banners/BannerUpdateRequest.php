<?php

namespace App\Http\Requests\Dashboard\Banners;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BannerUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3048',
        ];
    }
}
