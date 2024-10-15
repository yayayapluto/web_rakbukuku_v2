<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'rack_id',
        'category_id',
        'title',
        'isbn',
        'writer',
        'publisher',
        'publish_year',
        'cover',
        'soft_file',
        'stock',
    ];

    public function rack(): BelongsTo
    {
        return $this->belongsTo(Rack::class, 'rack_id', 'rack_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class, 'book_id', 'book_id');
    }
}
