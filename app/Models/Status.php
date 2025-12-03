<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'emoji', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
