<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{
    use HasFactory;

    protected $table = 'post_attachments';
    protected $fillable = [
        'media',
        'media_type',
        'media_thumbnail',
        'post_id',
        'media_new',
    ];
}
