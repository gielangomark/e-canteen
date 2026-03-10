<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pickup_time' => ['required', 'in:istirahat_1,istirahat_2'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'pickup_time.required' => 'Waktu pengambilan wajib dipilih.',
            'pickup_time.in' => 'Waktu pengambilan tidak valid.',
        ];
    }
}
