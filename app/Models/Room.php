<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    protected $fillable = ['room_type_id', 'room_number', 'floor', 'status'];

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class)->withTimestamps();
    }

    // --- Scopes ---

    public function scopeSearch($query, $term)
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('room_number', 'like', "%{$term}%")
              ->orWhere('status', 'like', "%{$term}%");
        });
    }
}