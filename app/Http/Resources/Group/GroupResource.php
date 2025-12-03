<?php

namespace App\Http\Resources\Group;

use App\Models\GroupMember;
use App\Models\GroupRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'image'                 =>  $this->image,
            'title'                 =>  $this->title,
            'description'           =>  $this->description,
            'group_type'            => $this->group_type,
            'is_joined'             =>  GroupMember::where(['group_id' => $this->id, 'user_id' => auth()->id()])->count(),
            'member_count'           =>  GroupMember::where(['group_id' => $this->id])->count(),
            'group_request_status'   => $this->request_status($this->id),
            'created_at'            =>  $this->created_at,
            'created_by'            => [
                'id'                    =>  $this->created_by->id,
                'full_name'             =>  $this->created_by->full_name,
                'user_name'             =>  $this->created_by->user_name,
                'profile_image'         =>  $this->created_by->profile_image,
                'status'                =>  $this->created_by->status,
            ],
            // 'members'               =>  MemberResource::collection($this->members),
            'interests'               =>  InterestResource::collection($this->interest)

        ];
    }

    private function request_status($group_id)
    {
        $group_request =  GroupRequest::where(['group_id' => $group_id, 'user_id' => auth()->id()])->first('status');
        if ($group_request) {
            return $group_request->status;
        } else {
            return null;
        }
    }
}
