<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HowToPaint;
use App\HowToPaintContent;

class HowToPaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $HowToPaint = HowToPaint::where('status',1)->with(['SubTitles' => function($q) {
            $q->where('status',1);
        }])->with('Contents')->get();
        return view('user.how-to-paint.index', compact('HowToPaint'));
    }
}
