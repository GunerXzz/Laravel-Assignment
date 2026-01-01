<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    protected $fillable = ['customer_id', 'check_in', 'check_out', 'status', 'note'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class)->withTimestamps();
    }

    // --- Scopes ---

    public function scopeSearch($query, $term)
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('status', 'like', "%{$term}%")
              ->orWhere('note', 'like', "%{$term}%")
              ->orWhereHas('customer', function ($cq) use ($term) {
                  $cq->where('full_name', 'like', "%{$term}%");
              })
              ->orWhereHas('rooms', function ($rq) use ($term) {
                  $rq->where('room_number', 'like', "%{$term}%");
              });
        });
    }
}