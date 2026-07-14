<?php

namespace App\Models;

use Database\Factories\GuestFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    /** @use HasFactory<GuestFactory> */
    use HasFactory;

    protected $fillable = [
        'instansi',
        'tujuan',
        'jumlah_personil',
        'nama_pic',
        'no_hp',
        'notified',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_personil' => 'integer',
            'notified' => 'boolean',
        ];
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', now()->toDateString());
    }
}
