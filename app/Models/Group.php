<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 'title', 'description', 'group_type', 'created_by_id'
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id')->with('status');
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class, 'group_id');
    }
    
     public function interest()
    {
        return $this->hasMany(GroupInterest::class, 'group_id');
    }
}
