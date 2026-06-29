<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['is_active', 'product_id', 'image', 'link'];

    protected $casts = ['is_active' => 'boolean'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
