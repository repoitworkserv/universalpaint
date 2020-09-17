<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProductReviewsandRating;


// model
use App\UserImages;


class ReviewsandRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $uid = Auth::id();
		
		//check if existing 
	
		 $prr_row = ProductReviewsandRating::with('ProductData')->with('UserData');
		 $prr = $prr_row->get();
		 $prr_count = $prr_row->count();
		 $status = '';
		 $alertclass ='';
		 if (Session::has('status')) {
            $status = Session::get('status');
			$alertclass = Session::get('alertclass');
            Session::forget('status');
			Session::forget('alertclass');
		}
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
		 return view('admin.content-management.reviews-and-rating.index',compact('uimage','prr','prr_count','status','alertclass'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
              
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
	
	public function review_ratings(Request $request)
	{
		$action = $request->revaction;
		$revid = $request->revid;
        $rec_updte = ProductReviewsandRating::find($revid);
        $rec_row = ProductReviewsandRating::findOrFail($revid);
		//$rec_updte = $rec_row[0];
		if($action == 1){
			$rec_updte->is_approved = $action;
			if($rec_updte->save()){
				return redirect()->action('Admin\ReviewsandRatingController@index')->with('status', 'Success! New Reviews and Ratings updated from pending to approved.')->with('alertclass','success');
			}
		}else if($action == 0){
			//$rec_updte->is_approved = $action;
			if($rec_row->delete()){
				return redirect()->action('Admin\ReviewsandRatingController@index')->with('status', 'Reviews and Ratings successfully deleted.')->with('alertclass','success');
			}
		}else{
			return redirect()->action('Admin\ReviewsandRatingController@index')->with('status', 'Please contact your IT support for checking.')->with('alertclass','danger');
		}
	//	print_r($request->all()); exit();
	}
}
