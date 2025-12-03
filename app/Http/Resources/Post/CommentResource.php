<?php

namespace App\Http\Resources\Post;

use App\Models\Follow;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment'               =>  $this->comment,
            'likes_count'           =>  $this->likes_count($this->id),
            'is_like'               =>  Like::where(['user_id' => auth()->id(), 'record_id' => $this->id, 'like_type' => 'comment'])->count(),
            'created_at'            =>  $this->created_at,
            'created_by'            => [
                'id'                    =>  $this->user->id,
                'full_name'             =>  $this->user->full_name,
                'user_name'             =>  $this->user->user_name,
                'profile_image'         =>  $this->user->profile_image,
                'status'                =>  $this->user->status,
                'is_follow'             =>  Follow::where(['follower_id' => auth()->id(), 'following_id' => $this->user->id, 'status' => 'accept'])->count()
            ],
            'reply_count'            => count($this->child_comments),
            'child_comments'         => CommentResource::collection($this->child_comments),
        ];
    }

    private function likes_count($id)
    {
        return Like::where(['record_id' => $id, 'like_type' => 'comment'])->count();
    }
}
