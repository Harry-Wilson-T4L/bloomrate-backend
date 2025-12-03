<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\HelpAndFeedBack;
use App\Models\Interest;
use App\Models\Post;
use App\Models\Report;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        return view('admin.home.index', compact('title'));
    }

    public function helpAndFeedback()
    {
        $title = 'Help and FeedBack';
        $helpAndFeedbacks = HelpAndFeedBack::with('user')->latest()->get();
        $tableHeadings = ['Full Name', 'Email', 'Profile Image', 'Subject', 'description', 'Images', 'Created At'];
        return view('admin.help-and-feedback.index', compact('title', 'helpAndFeedbacks', 'tableHeadings'));
    }

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */
    public function usersList()
    {
        $title = 'Users';
        $users = User::where('user_type', '!=', 'admin')->otpVerified()->profileCompleted()->latest()->get();
        $tableHeadings = ['Full Name', 'Profile Image', 'E-mail', "Profession", 'Status', 'Country', 'State', 'City', 'Login Type', 'Is Block'];
        return view('admin.users.index', compact('title', 'users', 'tableHeadings'));
    }

    public function userBlock($id, $is_block)
    {
        try{
            if($is_block == '1'){
                $is_block = '0';
                $messageTitle = 'Un Blocked';
            } else {
                $is_block = '1';
                $messageTitle = 'Blocked';
                $user = User::find($id);
                $user->tokens()->delete();
            }

            User::whereId($id)->update(['is_blocked' => $is_block]);
            return redirect('admin/users')->with('success', 'User has been ' . $messageTitle);
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        } 
    }

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */
    public function statusList()
    {
        $title = 'Status';
        $statuses = Status::latest()->get();
        $tableHeadings = ['Title', 'Emoji', 'Is Active', 'Action'];
        return view('admin.status.index', compact('title', 'statuses', 'tableHeadings'));
    }

    public function statusForm()
    {
        $title = 'Status';
        return view('admin.status.form', compact('title'));
    }

    public function statusFormSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'title'      => 'required|max:255|unique:statuses,title',
            'emoji'      => 'required'
        ]);    
        try{
            Status::create($request->only('title', 'emoji'));
            return redirect('admin/status')->with('success', 'Status has been saved.');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function statusUpdate($id, $status)
    {
        try{
            if($status == '1'){
                $status = '0';
            } else {
                $status = '1';
            }

            Status::whereId($id)->update(['status' => $status]);
            return redirect('admin/status')->with('success', 'Status has been update.');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        } 
    }

    /*
    |--------------------------------------------------------------------------
    | Interests
    |--------------------------------------------------------------------------
    */
    public function interestList()
    {
        $title = 'Interest';
        $interests = Interest::latest()->get();
        $tableHeadings = ['Title', 'Is Active', 'Action'];
        return view('admin.interest.index', compact('title', 'interests', 'tableHeadings'));
    }

    public function interestForm()
    {
        $title = 'Interest';
        return view('admin.interest.form', compact('title'));
    }

    public function interestFormSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'title'      => 'required|max:255|unique:interests,title'
        ]);    

        try{
            Interest::create($request->only('title', 'emoji'));
            return redirect('admin/interests')->with('success', 'Interest has been saved.');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function interestUpdate($id, $status)
    {
        try{
            if($status == '1'){
                $status = '0';
            } else {
                $status = '1';
            }

            Interest::whereId($id)->update(['status' => $status]);
            return redirect('admin/interests')->with('success', 'Interest has been update.');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        } 
    }

    /*
    |--------------------------------------------------------------------------
    | Report
    |--------------------------------------------------------------------------
    */
    public function reportedPostList()
    {
        $title = 'Reported Posts';
        $reports = Report::with('post.user', 'user')->latest()->get();
        $tableHeadings = ['Reporter Name', 'Reporter Email', 'Profile Image', 'Post Title', 'Post Type', 'Post Author Name', 'Post Author Email', 'Reported At', 'Is Block'];
        return view('admin.post-report.index', compact('title', 'reports', 'tableHeadings'));
    }

    public function reportedPostUpdate($id, $status)
    {
        try{
            if($status == '1'){
                $status = '0';
            } else {
                $status = '1';
            }

            Post::whereId($id)->update(['is_block' => $status]);
            return redirect('admin/reported/posts')->with('success', 'Post has been update.');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        } 
    }
    
    /*
    |--------------------------------------------------------------------------
    | Content
    |--------------------------------------------------------------------------
    */
    public function getContent($type)
    {
        if($type == 'pp'){
            $title = 'Privacy Policy';
        } else if($type == 'tc') {
            $title = 'Terms and Conditions';
        }else{
            $title = 'About Us';
        }

        $content = Content::where('type', $type)->first();
        return view('admin.content.index', compact('title', 'content'));
    }

    public function updateContent(Request $request, $type)
    {
        try{
            $content = Content::where('type', $type)->update(['content' => $request->content]);
            return redirect('admin/content/'.$type)->with('success', 'Content has been update.');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        } 
    }


    public function interestDelete($id){
        try{
            Interest::whereId($id)->delete();
            return redirect('admin/interests')->with('success', 'Interest deleted successfully.');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function statusDelete($id){
        try{
            Status::whereId($id)->delete();
            return redirect('admin/status')->with('success', 'Status deleted successfully.');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    
}
