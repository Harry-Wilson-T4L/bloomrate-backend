<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPhoneBook extends Model
{
    use HasFactory;
    
     protected $table = 'user_phone_books';
     
     protected $fillable  = [
        'user_id',
        'content'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
