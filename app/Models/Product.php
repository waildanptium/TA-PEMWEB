<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean', 'expiry_date' => 'date'];

    protected function finalPrice(): Attribute
    {
        return Attribute::get(fn () => (int) round($this->price * (100 - $this->discount_percent) / 100));
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image ? Storage::disk('s3')->url($this->image) : null);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}