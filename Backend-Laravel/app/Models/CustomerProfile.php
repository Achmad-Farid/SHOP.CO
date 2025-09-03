<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','date_of_birth','gender','avatar_url','tax_number','marketing_opt_in',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'marketing_opt_in' => 'bool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
