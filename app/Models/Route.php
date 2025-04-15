<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'name',
        'bus_id',
        'from',
        'to',
        'departure_time',
        'arrival_time',
        'fare',
        'status'
    ];

    protected $casts = [
        'fare' => 'decimal:2',
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    //
}
