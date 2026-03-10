<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBalanceRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Jumlah saldo wajib diisi.',
            'amount.numeric' => 'Jumlah saldo harus berupa angka.',
            'amount.min' => 'Jumlah saldo minimal Rp 1.000.',
        ];
    }
}
