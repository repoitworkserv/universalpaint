<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

//models
use App\PaymentMethod;
use App\UserImages;

class PaymentMethodController extends Controller
{
    /*
    * @var \App\PaymentMethod
    */
    protected $paymentMethod;

    /**
    * PaymentMethodController constructor
    * @params \App\PaymentMethod $paymentMethod
    */
    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $paymentMethodAll = $this->paymentMethod->getAll();

        $paymentMethod = array();
        foreach ($paymentMethodAll as $key => $value) {
            switch ($value['method']) {
                case 'eghl':
                    $paymentMethod['eghl'][$value['key']] = $value['value'];
                    break;
                case 'paypal':
                    $paymentMethod['paypal'][$value['key']] = $value['value'];
                    break;
                case 'dragonpay':
                    $paymentMethod['dragonpay'][$value['key']] = $value['value'];
                    break;
                case 'bank_deposit':
                    $paymentMethod['bank_deposit'][$value['key']] = $value['value'];
                    break;
            }    
        }
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        return view('admin.payment-method.index', compact('uimage','paymentMethod'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     
        //Delete all data from this method
        $this->paymentMethod->resetPaymentMethod($request->method);

        //recreate array for multiple saving
        $data = array();
        foreach($request->all() as $key => $val){
            $meta = array();
            if(($key != "_token") && ($key != "method")){
                $meta['method'] = $request->method;
                $meta['key'] = $key;
                $meta['value'] = $val;
                $meta['created_at'] =new \DateTime();
                $meta['updated_at'] =new \DateTime();

                array_push($data,$meta);
            }
        }

        if($this->paymentMethod->saveMethodKeyValue($data)){
            //success on save
            $message = 'Payment method successfully save!';
            return redirect()->action('Admin\PaymentMethodController@index')->with('status', $message);
        }

        //error on save
        $message = 'Payment method failed to save!';
        return redirect()->back()->with('status', $message);

    }

}
