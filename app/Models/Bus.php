<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Bus extends Model
{
    protected $fillable = [
        'name',
        'bus_number',
        'type',
        'total_seats',
        'features',
        'status',
        'image'
    ];

    protected $appends = ['image_url'];

    protected $casts = [
        'total_seats' => 'integer',
    ];

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function getImageUrlAttribute()
    {
        if (!empty($this->image)) {
            $path = 'buses/' . $this->image;
            if (Storage::disk('public')->exists($path)) {
                return asset('storage/' . $path);
            }
        }
        return asset('images/default-bus.jpg');
    }
}
