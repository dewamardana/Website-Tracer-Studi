<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'program_studi', 'asal_sekolah', 'alamat', 'no_telepon',
    ];

    public function answers()
    {
        return $this->hasMany(AnswerDetail::class, 'user_id');
    }
    
    public function kategori(): HasMany
    {
        return $this->hasMany(Kategori::class);
    }

    public function form(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    public function template(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $casts = [
        'role' => 'array', // Otomatis decode JSON ke array saat mengakses.
    ];
}
