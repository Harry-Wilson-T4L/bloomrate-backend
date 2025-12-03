<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRequest extends Model
{
    use HasFactory;

    protected $table = 'group_requests';
    
    protected $fillable = [
        'group_id', 'user_id', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'full_name', 'email', 'profile_image');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
