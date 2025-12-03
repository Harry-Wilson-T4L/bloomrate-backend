<?php

namespace App\Http\Resources;

use App\Exceptions\CustomValidationException;
use App\Models\Follow;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->user_type == 'admin'){
            throw new CustomValidationException('User not found.');
        }
        return [
            'id'                        =>   $this->id,
            'full_name'                 =>   $this->full_name,    
            'user_name'                 =>   $this->user_name, 
            'email'                     =>   $this->email,                 
            'profile_image'             =>   $this->profile_image,                 
            'cover_image'               =>   $this->cover_image,               
            'phone_number'              =>   $this->phone_number,
            'age'              =>   $this->age, 
            'bio'              =>   $this->bio, 

            'profession'                =>   $this->profession,          
            'status'                    =>   Status::whereId($this->status_id)->select('id', 'title', 'emoji')->first(),                 
            'country'                   =>   $this->country,               
            'state'                     =>   $this->state,                 
            'city'                      =>   $this->city,
            'is_profile_complete'       =>   $this->is_profile_complete,              
            'device_type'               =>   $this->device_type,              
            'device_token'              =>   $this->device_token,                
            'is_forgot'                 =>   $this->is_forgot,            

            'push_notification'         =>   $this->push_notification,                
            'post_comment_notification' =>   $this->post_comment_notification,                
            'follower_notification'     =>   $this->follower_notification,                
            'is_sharing'                =>   $this->is_sharing,                
            'is_phone_book'             =>   $this->is_phone_book,                
            
            'is_verified'               =>   $this->is_verified,              
            'is_social'                 =>   $this->is_social,                      
            'is_active'                 =>   $this->is_active,                
            'is_blocked'                =>   $this->is_blocked,
            'is_profile_private'        =>   $this->is_profile_private,
            'interest'                  =>   UserInterestResource::collection($this->user_interest),
            'follow_status'             =>   $this->followStatus(auth()->id(), $this->id),
            'follow_status_data'        =>   $this->followStatusData(auth()->id(), $this->id),
            'is_follow'                 =>   Follow::where(['follower_id' => auth()->id(), 'following_id' => $this->id, 'status' => 'accept'])->count()        ];
    }

    private function followStatus($authId, $userId)
    {
        if($authId == $userId){
            return null;
        } else{
            
            $followList = Follow::where('follower_id', $authId)->where('following_id', $userId)->first();
      
            if(!empty($followList)){
                return $followList->status;
            } else{
                return null;
            }
        }
    }
    
     private function followStatusData($authId, $userId)
    {
        if($authId == $userId){
            return null;
        } else{
            
            $followList = Follow::where('follower_id', $authId)->where('following_id', $userId)->first();
            if(!$followList){
              $followList = Follow::where('follower_id', $userId)->where('following_id', $authId)->first();
            }
            
            if(!empty($followList)){
                return $followList;
            } else{
                return null;
            }
        }
    }
}
