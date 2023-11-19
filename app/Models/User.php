<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'address',
        'terms_accepted',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function scopeExceptCurrentUser($query) {
        return $query->where('id', '!=', auth()->user()->id);
    }

    public function getFullNameAttribute()
    {
    	return ucwords("{$this->first_name} {$this->last_name}");
    }

    public function scopeCurrentUser($query) {
        return $query->where('id', auth()->user()->id);
    }
}
