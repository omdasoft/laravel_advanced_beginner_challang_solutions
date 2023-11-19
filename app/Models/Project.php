<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['title', 'description', 'dateline', 'status', 'user_id', 'client_id'];

    protected $casts = [
        'status' => StatusEnum::class
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function client() 
    {
        return $this->belongsTo(Client::class);
    }
}
