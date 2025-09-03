<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * GET /me
     * Kembalikan data user + relasi profile & addresses
     */
    public function me(Request $request)
    {
        return $request->user()->load(['profile', 'addresses']);
    }

    /**
     * PUT /me/profile
     * Update data User (name, phone) + CustomerProfile (dob, gender, dst)
     * Gunakan FormRequest untuk validasi
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        // Pisahkan input untuk user vs profile
        $userData = $request->safe()->only(['name', 'phone']);

        $profileData = $request->safe()->only([
            'date_of_birth', 'gender', 'avatar_url', 'tax_number', 'marketing_opt_in'
        ]);

        if (!empty($userData)) {
            $user->update($userData);
        }

        $profile = $user->profile()->firstOrCreate([]);
        if (!empty($profileData)) {
            $profile->update($profileData);
        }

        return $user->load(['profile', 'addresses']);
    }
}
