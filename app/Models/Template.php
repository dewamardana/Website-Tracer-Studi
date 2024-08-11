<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function form(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    
}
