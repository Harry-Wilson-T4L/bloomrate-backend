<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
