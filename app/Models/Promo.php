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
        'valid_until',
        'activated',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'activated'   => 'boolean',
    ];

    // Format diskon untuk ditampilkan di index/trash
    public function getFormattedDiscountAttribute()
    {
        return $this->type === 'percent'
            ? $this->discount . '%'
            : 'Rp ' . number_format($this->discount, 0, ',', '.');
    }

    // Badge status aktif/nonaktif
    public function getStatusBadgeAttribute()
    {
        return $this->activated
            ? '<span class="badge bg-success">Aktif</span>'
            : '<span class="badge bg-secondary">Nonaktif</span>';
    }

    public function getValidityStatusAttribute()
    {
        if (!$this->valid_until) {
            return '<span class="badge bg-secondary">Tidak ada tanggal</span>';
        }

        return now()->gt($this->valid_until)
            ? '<span class="badge bg-danger">Invalid</span>'
            : '<span class="badge bg-success">Valid</span>';
    }
}
