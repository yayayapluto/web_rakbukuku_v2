<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rack extends Model
{
    use HasFactory;

    protected $fillable = [
        'rack_id',
        'name',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'rack_id', 'rack_id');
    }
}
