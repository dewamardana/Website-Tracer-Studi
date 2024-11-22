<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kategori(): BelongsTo
    {
        return $this->BelongsTo(Kategori::class);
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

    public function form(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
