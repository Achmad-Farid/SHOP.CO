<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sudah diproteksi auth:sanctum; bolehkan saja di sini
        return true;
    }

    public function rules(): array
    {
        return [
            // User
            'name'  => ['sometimes','string','max:255'],
            'phone' => ['sometimes','nullable','string','max:30'],

            // CustomerProfile
            'date_of_birth'    => ['sometimes','date'],
            'gender'           => ['sometimes','in:male,female,other'],
            'avatar_url'       => ['sometimes','nullable','url'],
            'tax_number'       => ['sometimes','nullable','string','max:50'],
            'marketing_opt_in' => ['sometimes','boolean'],
        ];
    }
}
