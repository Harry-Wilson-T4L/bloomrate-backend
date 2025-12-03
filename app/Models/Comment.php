<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'post_id', 'comment', 'parent_id'
    ];

    protected $hidden = [
        'user_id',
        'post_id',
        'parent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->with('status');
    }

    public function child_comments()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user');//->select(['id', 'user_id', 'post_id', 'parent_id', 'comment', 'created_at']);
    }
}
