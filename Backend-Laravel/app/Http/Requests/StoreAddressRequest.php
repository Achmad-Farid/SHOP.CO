<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sudah lewat auth:sanctum
    }

    public function rules(): array
    {
        return [
            'label'          => ['nullable','string','max:50'],
            'recipient_name' => ['required','string','max:120'],
            'phone'          => ['nullable','string','max:30'],

            'address_line1'  => ['required','string','max:255'],
            'address_line2'  => ['nullable','string','max:255'],
            'village'        => ['nullable','string','max:120'],
            'district'       => ['nullable','string','max:120'],
            'city'           => ['required','string','max:120'],
            'province'       => ['required','string','max:120'],
            'postal_code'    => ['required','string','max:10'],

            'notes'               => ['nullable','string','max:500'],
            'is_default_shipping' => ['boolean'],
            'is_default_billing'  => ['boolean'],
        ];
    }
}
