<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'user_name',
        'email',
        'password',
        'profile_image',
        'cover_image',
        'user_type',
        'profession',
        'status_id',
        'phone_number',
        'age',
        'bio',
        // 'address',
        // 'latitude',
        // 'longitude',
        'country', 
        'state', 
        'city', 
        'is_profile_complete',
        'device_type',
        'device_token',
        'social_type',
        'social_token',
        'is_forgot',
        'push_notification',
        'post_comment_notification',
        'follower_notification',
        'is_verified',
        'is_social',
        'verified_code',
        'is_active',
        'is_blocked',
        'is_deleted',
        'online_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeOtpVerified($query)
    {
        return $query->where('is_verified', '1');
    }

    public function scopeProfileCompleted($query)
    {
        return $query->where('is_profile_complete', '1');
    }

    function user_interest()
    {
        return $this->hasMany(UserInterest::class, 'user_id')->with('interest');    
    }

    function status()
    {
        return $this->belongsTo(Status::class, 'status_id')->select('id', 'title', 'emoji')->withDefault();    
    }

    public function followers()
{
    return $this->hasMany(Follow::class, 'following_id', 'id');
}

public function followings()
{
    return $this->hasMany(Follow::class, 'follower_id', 'id');
}

}
