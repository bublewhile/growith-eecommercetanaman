<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    // use SoftDeletes;

    protected $table = 'comments';


    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
