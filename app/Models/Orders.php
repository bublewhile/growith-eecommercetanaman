<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'shipping_fee',
        'status',
        'promo_id',
        'size',
        'pot_material',
        'pot_color',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Promo
    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    // Relasi ke OrderPayment
    public function orderPayment()
    {
        return $this->hasOne(orderPayment::class, 'order_id');
    }
}
