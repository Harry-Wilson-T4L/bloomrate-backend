<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'interest_id'
    ];

    function interest()
    {
        return $this->belongsTo(Interest::class, 'interest_id')->select('id', 'title');    
    }
}
