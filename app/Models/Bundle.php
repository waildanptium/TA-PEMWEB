<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];

    public function items()
    {
        return $this->hasMany(BundleItem::class);
    }

    protected function normalPrice(): Attribute
    {
        return Attribute::get(fn () => $this->items->sum(fn ($i) => $i->product->final_price * $i->qty));
    }
}