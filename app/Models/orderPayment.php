<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class orderPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'barcode',
        'status',
        'booked_date',
        'paid_date',
    ];

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
