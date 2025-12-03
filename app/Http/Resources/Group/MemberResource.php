<?php

namespace App\Http\Resources\Group;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id'                    =>  $this->user->id,
            'full_name'             =>  $this->user->full_name,
            'user_name'             =>  $this->user->user_name,
            'profile_image'         =>  $this->user->profile_image,
            'status'                =>  $this->user->status,
        ];
    }
}
