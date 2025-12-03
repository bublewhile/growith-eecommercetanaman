<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'price',
        'stock',
        'brand',
        'description',
        'image',
        'actived',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi Like
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes', 'product_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'product_id');
    }


}
