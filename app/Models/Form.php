<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'tipe'];


        public function template(): BelongsTo
    {
        return $this->BelongsTo(Template::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Questions::class);
    }

     public function jawaban(): HasMany
    {
        return $this->hasMany(Jawaban::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
