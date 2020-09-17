<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Post;
use App\PostMetaData;

class AboutController extends Controller
{
    public function index()
    {
    	
		$postmetadata = PostMetaData::where('display_name','About Us')->with('PostData')->get();
		$uid = Auth::id();
		if($postmetadata->count() > 0){
			return view('user/aboutus', compact('postmetadata', 'uid'));
		}else{
			abort(404);
		}
    	
	}
}
