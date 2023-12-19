<?php

namespace App\Http\Requests\WebSite;

use Illuminate\Foundation\Http\FormRequest;

class EditOrderItemRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,confirmed,delivered',
            'note' => 'nullable|string',
            'quantity' => 'required|numeric|max:3',
        ];
    }
}
