<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\EditionType;
use App\Observers\BookObserver;

class Book extends Model
{
    protected $fillable = ['title', 'edition', 'user_id'];

    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();
        self::observe(BookObserver::class);
    }

    protected $casts = [
        'edition' => EditionType::class,
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
