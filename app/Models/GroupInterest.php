<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupInterest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'group_id', 'interest_id'
    ];

    function group_interest()
    {
        return $this->belongsTo(Interest::class, 'interest_id')->select('id', 'title');    
    }
}
