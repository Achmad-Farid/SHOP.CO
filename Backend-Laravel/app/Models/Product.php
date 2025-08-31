<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id','name','slug','short_description','description',
        'base_price','compare_at_price','rating_avg','rating_count',
        'min_variant_price','status'
    ];

    public function category(){ return $this->belongsTo(Category::class); }
    public function images(){ return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function variants(){ return $this->hasMany(ProductVariant::class); }
    public function reviews(){ return $this->hasMany(Review::class); }
    public function faqs(){ return $this->hasMany(ProductFaq::class); }
    public function orderItems(){ return $this->hasMany(OrderItem::class); }
}
