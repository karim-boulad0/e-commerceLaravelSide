<?php

namespace App\Http\Requests\Dashboard\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUpdateRequest extends FormRequest
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
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'nullable',
            'description' => 'nullable',
            'price' => 'nullable | numeric',
            'discount' => 'nullable ',
            'About' => 'nullable',
            'delivery_price' => 'nullable',
            'quantity' => 'nullable',
            'status' => 'nullable',
        ];
    }
}
