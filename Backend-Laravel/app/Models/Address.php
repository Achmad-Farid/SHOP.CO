<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id','label','recipient_name','phone',
        'address_line1','address_line2',
        'village','district','city','province','postal_code',
        'notes','is_default_shipping','is_default_billing',
    ];

    protected $casts = [
        'is_default_shipping' => 'bool',
        'is_default_billing'  => 'bool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
