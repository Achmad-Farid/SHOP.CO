<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFaq extends Model
{
    protected $fillable = ['product_id','user_id','question','answer','answered_by','status'];

    public function product(){ return $this->belongsTo(Product::class); }
    public function user(){ return $this->belongsTo(User::class,'user_id'); }
    public function answeredBy(){ return $this->belongsTo(User::class,'answered_by'); }
}
