<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestVideo extends Model
{
    use HasFactory;

    protected $table = 'interest_videos';
    
    protected $fillable = [
        'user_id', 'post_id', 'status'
    ];
}
