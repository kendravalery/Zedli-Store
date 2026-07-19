<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Searchable;
    protected $fillable = ['user_id', 'category_id', 'name', 'slug', 'description', 'price', 'stock', 'is_active', 'attributes', 'is_limited', 'limited_quantity'];

    protected $casts = ['attributes' => 'array', 'is_active' => 'boolean', 'is_limited' => 'boolean'];
    public function toSearchableArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'description' => $this->description, 'price' => (float)$this->price, 'category_id' => $this->category_id];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
