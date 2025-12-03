<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlock extends Model
{
    use HasFactory;
    
    protected $table = "user_blocks";
    protected $fillable = [
        'user_id', 'blocked_user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blocked_user()
    {
        return $this->belongsTo(User::class, 'blocked_user_id')->select('id', 'full_name', 'user_name', 'email', 'profile_image', 'cover_image', 'user_type');
    }
}
