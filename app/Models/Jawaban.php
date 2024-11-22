<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jawaban extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function answerDetail(): HasMany
    {
        return $this->hasMany(answerDetail::class);
    }
    public function form(): BelongsTo
    {
        return $this->BelongsTo(Form::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

        public function user(): BelongsTo
    {
        return $this->BelongsTo(SectionDump::class);
    }

    // public function template(): BelongsTo
    // {
    //     return $this->BelongsTo(Template::class);
    // }

    
}
