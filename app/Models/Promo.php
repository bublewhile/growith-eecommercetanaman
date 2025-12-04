<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'promo_code',
        'discount',
        'type',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    // Format diskon untuk ditampilkan di index/trash
    public function getFormattedDiscountAttribute()
    {
        return $this->type === 'percent'
            ? $this->discount . '%'
            : 'Rp ' . number_format($this->discount, 0, ',', '.');
    }

    // Status validitas promo berdasarkan tanggal
    public function getStartDateFormattedAttribute()
    {
        return $this->start_date ? $this->start_date->format('d M Y') : '-';
    }

    public function getEndDateFormattedAttribute()
    {
        return $this->end_date ? $this->end_date->format('d M Y') : '-';
    }
}
