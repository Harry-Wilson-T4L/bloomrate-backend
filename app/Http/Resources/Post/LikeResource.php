<?php

namespace App\Http\Resources\Post;

use App\Models\Follow;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    =>  $this->id,
            'reaction_type'         =>  $this->reaction_type,
            'like_type'             =>  $this->like_type,
            'created_at'            =>  $this->created_at,
            'created_by'            => [
                'id'                    =>  $this->user->id,
                'full_name'             =>  $this->user->full_name,
                'user_name'             =>  $this->user->user_name,
                'profile_image'         =>  $this->user->profile_image,
                'status'                =>  $this->user->status,
                'is_follow'             =>  Follow::where(['follower_id' => auth()->id(), 'following_id' => $this->user->id, 'status' => 'accept'])->count()
            ]
        ];
    }
}
