<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'following_id', 'follower_id', 'status'
    ];

    public function following_user()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
