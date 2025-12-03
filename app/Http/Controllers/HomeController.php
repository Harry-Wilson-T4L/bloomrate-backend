<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function content($type)
    {
        $content = Content::where('type', $type)->first();
        return view('content.index', compact('content'));
    }
}
