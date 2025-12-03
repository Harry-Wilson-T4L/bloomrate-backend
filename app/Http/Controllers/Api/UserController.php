<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Follow;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{
    UserBlock,
    Notification,
    Chat,
};
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    use ApiResponser;

    /** Profile */
    public function profile(Request $request)
    {
        $this->validate($request, [
            'user_id'   =>  'required|exists:users,id',
        ]);

        return $this->successDataResponse('Profile.', new UserResource(User::find($request->user_id)));
    }

    /** Follow create */
    public function followCreate(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id'
        ]);

        try {
            DB::beginTransaction();
            $authId = auth()->user()->id;

            // Check if user can not send follow request on his own account
            if ($authId == $request->user_id) {
                return $this->errorResponse("Can't follow your account", 400);
            }

            $already_followed = Follow::where('follower_id', $authId)->where('following_id', $request->user_id)->where('status', 'accept')->first();

            if (!empty($already_followed)) {
                // Unfollow 
                $already_followed->delete();
                DB::commit();
                return $this->successResponse('Unfollow successfully.');
            } else {
                
                // Checking if request already has send
                $already_requested = Follow::where('follower_id', $authId)->where('following_id', $request->user_id)->where('status', 'pending')->first();
                if (!empty($already_requested)) {
                    DB::commit();
                    return $this->successResponse('A request has already been sent by you.');
                }

                $user = User::whereId($request->user_id)->first();

                // Follow request
                $follow = new Follow;
                $follow->follower_id = $authId;
                $follow->following_id = $request->user_id;
                $follow->status = $user->is_profile_private == '1' ? 'pending' : 'accept'; // Checking user profile
                $follow->save();

                // Notification 
                $notification = [
                    'device_token'  => $user->device_token,
                    'sender_id'     => $authId,
                    'receiver_id'   => $user->id,
                    'title'         => auth()->user()->full_name . ' has follow you.',
                    'description'   => null,
                    'record_id'     =>  auth()->id(),
                    'type'          => 'follow_you',
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];

                if ($user->follower_notification == '1' && $user->device_token != null) {
                    push_notification($notification, $user->device_token);
                }
                in_app_notification($notification);

                try{
                // Get unread notification count www
                    $unreadCount = Notification::where([
                        'receiver_id' =>  $user->id,
                        'read_at' => null,
                        'seen' => '0'
                    ])->count();

                    emitSocketNotification($user->id, $unreadCount);

                } catch (\Exception $exception) {
                    Log::error('Notification Count Error: ' . $exception->getMessage());
                    return response()->json(['error' => 'Failed to send notification'], 500);
                }

                // End Notification 
                DB::commit();

                $message = $user->is_profile_private == '1' ? 'Follow request has been send successfully.' : 'Follow successfully.';
                return $this->successDataResponse($message, new UserResource(User::find($request->user_id)));
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /** Pending follow request */
    function followRequests()
    {
        $blockUserId = UserBlock::where('user_id', auth()->id())->pluck('blocked_user_id')->toArray();

        $pendingList = Follow::select(
            // 'friend_lists.id as id',
            'users.id',
            'users.full_name',
            'users.user_name',
            'users.profile_image',
            'follows.created_at',
            'follows.status'
        )
        ->join('users', 'users.id', '=', 'follows.follower_id')
        ->where('follows.following_id', auth()->id())->where('follows.status', 'pending')->whereNotIn('follows.follower_id', $blockUserId)->latest()->get(); 
        
        return $this->successDataResponse('Pending requests.', $pendingList);
    }

    /** Accept / reject follow request */
    function followRequestAcceptReject(Request $request)
    {
        $this->validate($request, [
            'user_id'          =>  'required|exists:users,id',
            'status'           =>  'required|in:accept,reject'
        ]);

        $authId = auth()->id();
        $userId = $request->user_id;

        $followList = Follow::where('status', 'pending')
            ->where(function($q_1) use($authId, $userId) {
                $q_1->where(function($q) use($authId, $userId) {
                    $q->where('following_id', $authId)->where('follower_id', $userId);
                })
                ->orWhere(function($q) use($authId, $userId) {
                    $q->where('following_id', $userId)->where('follower_id', $authId);
                });
            })->first();

        if(!empty($followList)){
            if($request->status == 'accept'){
                $followList->status = 'accept';
                $followList->save();

                $user = User::whereId($userId)->first();
                // Notification 
                  $notification = [
                    'device_token'  => $user->device_token,
                    'sender_id'     => $authId,
                    'receiver_id'   => $user->id,
                    'title'         => auth()->user()->full_name . ' accepted your request.',
                    'description'   => null,
                    'record_id'     => $authId,
                    'type'          => 'follow_request_accept',
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];

                if ($user->follower_notification == '1' && $user->device_token != null) {
                    push_notification($notification, $user->device_token);
                }
                in_app_notification($notification);

                try{
                // Get unread notification count www
                    $unreadCount = Notification::where([
                        'receiver_id' =>  $user->id,
                        'read_at' => null,
                        'seen' => '0'
                    ])->count();

                    emitSocketNotification($user->id, $unreadCount);

                } catch (\Exception $exception) {
                    Log::error('Notification Count Error: ' . $exception->getMessage());
                    return response()->json(['error' => 'Failed to send notification'], 500);
                }

            }
            else{
                $followList->delete();
            }
            return $this->successResponse('Follow request ' . $request->status . 'ed successfully.', 200);
        } else{
            return $this->errorResponse('Follow request not found.', 400);
        }
    }

    /** Follow list */
    public function following(Request $request)
    {
        $this->validate($request, [
            'user_id'   =>  'required|exists:users,id',
        ]);

        $blockUserId = UserBlock::where('user_id', auth()->id())->pluck('blocked_user_id')->toArray();

        $following_ids = Follow::where('follower_id', $request->user_id)->where('status', 'accept')->pluck('following_id');

        if (count($following_ids) > 0) {

            $users = User::whereIn('users.id', $following_ids)->whereNotIn('id', $blockUserId)
            ->select('id', 'full_name', 'user_name', 'profile_image',
            DB::raw('(select count(id) from `follows` where (`follower_id` = '.$request->user_id.' and `following_id` = users.id) and `status` = "accept") as is_follow'))
            ->get();

            return $this->successDataResponse('Following list found.', $users);
        } else {
            return $this->errorResponse('Following list not found.', 400);
        }
    }

    /** Followers list */
    public function followers(Request $request)
    {
        $this->validate($request, [
            'user_id'   =>  'required|exists:users,id',
        ]);

        $blockUserId = UserBlock::where('user_id', auth()->id())->pluck('blocked_user_id')->toArray();

        $follower_ids = Follow::where('following_id', $request->user_id)->where('status', 'accept')->pluck('follower_id');
        if (count($follower_ids) > 0) {

            $users = User::whereIn('id', $follower_ids)->whereNotIn('id', $blockUserId)
            ->select('id', 'full_name', 'user_name', 'profile_image', 
            DB::raw('(select count(id) from `follows` where (`follower_id` = '.$request->user_id.' and `following_id` = users.id) and `status` = "accept") as is_follow'))
            ->get();

            return $this->successDataResponse('Follower list found.', $users);
        } else {
            return $this->errorResponse('Follower list not found.', 400);
        }
    }

    // Block User
    public function userBlockUnBlock(Request $request)
    {
        $this->validate($request, [
            'blocked_user_id' => 'required|exists:users,id',
        ]);

        $authId = auth()->user()->id;

        $blockUserId = $request->blocked_user_id;

        $checkUser = UserBlock::where('user_id', $authId)->where('blocked_user_id', $blockUserId)->first();
        if ($checkUser) {
            $checkUser->delete();
            return $this->successResponse('User unblocked successfully', 200);
        } else {
            // Block the user
            UserBlock::create(['user_id' => $authId, 'blocked_user_id' => $blockUserId]);
            return $this->successResponse('User blocked successfully', 200);
        }
    }

    // Block User List
    public function userBlockList()
    {

        $authId = auth()->user()->id;

        $blockUsers = UserBlock::with('blocked_user')->where('user_id', $authId)->get()
            ->map(function ($blockUsers) {
                return [
                    'id' => $blockUsers->blocked_user->id,
                    'full_name' => $blockUsers->blocked_user->full_name,
                    'user_name' => $blockUsers->blocked_user->user_name,
                    'email' => $blockUsers->blocked_user->email,
                    'profile_image' => $blockUsers->blocked_user->profile_image,
                    'cover_image' => $blockUsers->blocked_user->cover_image,
                    'user_type' => $blockUsers->blocked_user->user_type,
                ];
            })->toArray();

        if (count($blockUsers) > 0) {
            return $this->successDataResponse('Blocked users found successfully.', $blockUsers, 200);
        } else {
            return $this->errorResponse('Blocked users not found.', 400);
        }
    }
}
