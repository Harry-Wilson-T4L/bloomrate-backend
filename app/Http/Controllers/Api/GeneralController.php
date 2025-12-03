<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\HelpAndFeedBack;
use App\Models\Interest;
use App\Models\State;
use App\Models\Status;
use App\Models\Notification;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GeneralController extends Controller
{
    use ApiResponser;

    /** Interest list */
    public function interestList()
    {
        $interestList = Interest::active()->latest()->select('id', 'title')->get();
        return $this->successDataResponse('Interest list.', $interestList);
    }

    /** Status list */
    public function statusList()
    {
        $statusList = Status::active()->latest()->select('id', 'title', 'emoji')->get();
        return $this->successDataResponse('Status list.', $statusList);
    }

    /** Help and feedback */
    public function helpAndFeedback(Request $request)
    {
        $this->validate($request, [
            'subject'          =>      'required',
            'description'      =>      'required'
        ]);

        // $images = array();

        // if ($request->has('images')) {
        //     foreach ($request->images as $image) {
        //         $imageName = strtotime("now") . mt_rand(100000, 900000) . '.' . $image->getClientOriginalExtension();
        //         $image->move(public_path('/media/post_media'), $imageName);
        //         array_push($images, '/media/post_media/' . $imageName);
        //     }
        // }
        // ss33
        $images = array();

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $imageName = strtotime("now") . mt_rand(100000, 900000) . '.' . $image->getClientOriginalExtension();
                
                // Store the image to S3
                $imagePath = $image->storeAs('media/post_media', $imageName, 's3');
                
                // Add the S3 path to the images array
                array_push($images, $imagePath);
            }
        }

        $feedback = HelpAndFeedBack::create([
            'user_id'       =>  auth()->id(),
            'subject'       =>  $request->subject,
            'description'   =>  $request->description,
            'images'        =>  json_encode($images)
        ]);

        return $this->successResponse('Feedback has been submit successfully.');
    }

    /** Get country */
    public function getCountry()
    {
        try {
            $countries = Country::select('id', 'sortname', 'name', 'phonecode')->get();
            return $this->successDataResponse('Countries list.', $countries);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /** Get state */
    public function getState(Request $request)
    {
        $this->validate($request, [
            'country_id'   =>  'required|exists:countries,id',
        ]);

        try {
            $states = State::where('country_id', $request->country_id)->select('id', 'name')->get();
            return $this->successDataResponse('States list.', $states);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /** Get city */
    public function getCity(Request $request)
    {
        $this->validate($request, [
            'state_id'   =>  'required|exists:states,id',
        ]);

        try {
            $cities = City::where('state_id', $request->state_id)->select('id', 'name')->get();
            return $this->successDataResponse('Cities list.', $cities);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /** Notification List */
    public function notificationList(Request $request)
    {

        $this->validate($request, [
            'offset'       =>   'required|numeric',
        ]);

        $authId = auth()->user()->id;

        $notifications =  Notification::with('user:id,full_name,user_name,profile_image,cover_image')->where('receiver_id', $authId)->latest()->skip($request->offset)->take(10)->get();

        if (count($notifications) > 0) {
            Notification::where(['receiver_id' => auth()->id(), 'read_at' => null, 'seen' => '0'])->update(['read_at' => now(), 'seen' => '1']);
          
            try{
                // Get unread notification count www
                $unreadCount = Notification::where([
                    'receiver_id' =>  $authId,
                    'read_at' => null,
                    'seen' => '0'
                ])->count();

                emitSocketNotification($authId, $unreadCount);

            } catch (\Exception $exception) {
                Log::error('Notification Count Error: ' . $exception->getMessage());
                return response()->json(['error' => 'Failed to send notification'], 500);
            }

            return $this->successDataResponse("Notification list found successfully", $notifications, 200);
        } else {
            return $this->errorResponse("Notification list not found", 400);
        }
    }
    
     public function chatAttachment(Request $request)
    {
        $this->validate($request, [
            'attachment' => 'required|file'
        ]);

        // if ($request->hasFile('attachment')) {
        //     $attachment = time() . '.' . $request->attachment->getClientOriginalExtension();
        //     $request->attachment->move(public_path('/chat_attachments'), $attachment);
        //     $file_path = '/chat_attachments/' . $attachment;
        //     $url = $file_path;
        // }

        // if ($url) {
        //     return $this->successDataResponse('Attachment found successfully.', $url, 200);
        // } else {
        //     return $this->errorResponse('Attachment not found.', 400);
        // }
        // ss33
        if ($request->hasFile('attachment')) {
            // Get the uploaded file
            $file = $request->file('attachment');
            
            // Generate a unique filename for the file
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            // Store the file in 'chat_attachments' folder on S3
            $path = $file->storeAs('chat_attachments', $filename, 's3');
            
            // Return the S3 internal path
            $url = $path;
        }
        
        if ($url) {
            return $this->successDataResponse('Attachment uploaded successfully.', $url, 200);
        } else {
            return $this->errorResponse('Attachment not found.', 400);
        }
    }
}
