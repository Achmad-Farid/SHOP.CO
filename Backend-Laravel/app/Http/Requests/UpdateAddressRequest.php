<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // mirip Store, tapi semua "sometimes"
        return [
            'label'          => ['sometimes','nullable','string','max:50'],
            'recipient_name' => ['sometimes','string','max:120'],
            'phone'          => ['sometimes','nullable','string','max:30'],

            'address_line1'  => ['sometimes','string','max:255'],
            'address_line2'  => ['sometimes','nullable','string','max:255'],
            'village'        => ['sometimes','nullable','string','max:120'],
            'district'       => ['sometimes','nullable','string','max:120'],
            'city'           => ['sometimes','string','max:120'],
            'province'       => ['sometimes','string','max:120'],
            'postal_code'    => ['sometimes','string','max:10'],

            'notes'               => ['sometimes','nullable','string','max:500'],
            'is_default_shipping' => ['sometimes','boolean'],
            'is_default_billing'  => ['sometimes','boolean'],
        ];
    }
}
