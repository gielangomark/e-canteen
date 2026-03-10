<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'canteen_id',
        'total_amount',
        'status',
        'pickup_time',
        'notes',
        'order_date',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function canteen(): BelongsTo
    {
        return $this->belongsTo(Canteen::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getPickupTimeLabelAttribute(): string
    {
        return match ($this->pickup_time) {
            'istirahat_1' => 'Istirahat 1',
            'istirahat_2' => 'Istirahat 2',
            default => $this->pickup_time,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'preparing' => 'Sedang Disiapkan',
            'ready' => 'Siap Diambil',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'preparing' => 'blue',
            'ready' => 'emerald',
            'completed' => 'slate',
            'cancelled' => 'red',
            default => 'slate',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/20',
            'preparing' => 'bg-blue-500/15 text-blue-400 border-blue-500/20',
            'ready' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20',
            'completed' => 'bg-slate-500/15 text-slate-400 border-slate-500/20',
            'cancelled' => 'bg-red-500/15 text-red-400 border-red-500/20',
            default => 'bg-slate-500/15 text-slate-400 border-slate-500/20',
        };
    }
}
