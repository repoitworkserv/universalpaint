<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use DB;
use Config;
use Auth;
use App\UserImages;
use App\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $Supplier  = Supplier::paginate(10);
        $id = Auth::id();
        $uimage = UserImages::where('user_id',$id)->with('ImageData')->get();
        return view('admin.master-record.supplier.index', compact('uimage','Supplier'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_name'             => 'required',
            'supplier_code'             => 'required',
            'supplier_address'          => 'required',
            'supplier_contact_no'       => 'required',
            'supplier_email'            => 'required',
        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with(array('status'=>'error','msg'=>$message));
        } else {
            $supplier = new Supplier;
            $supplier->name                 = $request->supplier_name;
            $supplier->supplier_code        = $request->supplier_code;
            $supplier->address              = $request->supplier_address;
            $supplier->contact_no           = $request->supplier_contact_no;
            $supplier->email                = $request->supplier_email;
            $supplier->save();
            $message = 'Supplier is successfuly added';
        }
        return redirect()->back()->withInput()->with(array('status'=>'success','msg'=>$message));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_name'             => 'required',
            'supplier_code'             => 'required',
            'supplier_address'          => 'required',
            'supplier_contact_no'       => 'required',
            'supplier_email'            => 'required',
        ]);

        $message = '';
        if ($validator->fails()) {            
            foreach ($validator->errors()->all() as $error) {
                $message .= $error."\r\n";
            }
            return redirect()->back()->withInput()->with(array('status'=>'error','msg'=>$message));
        } else {
            $supplier = Supplier::find($request->e_supplier_id);
            $supplier->name                 = $request->e_supplier_name;
            $supplier->supplier_code        = $request->e_supplier_code;
            $supplier->address              = $request->e_supplier_address;
            $supplier->contact_no           = $request->e_supplier_contact_no;
            $supplier->email                = $request->e_supplier_email;
            $supplier->save();
            $message = 'Supplier is successfuly updated';
        }
        return redirect()->back()->withInput()->with(array('status'=>'success','msg'=>$message));
    }

    public function destroy($id)
    {
        $delete =  Supplier::find($id)->delete();
        $message = 'Supplier successfully deleted!';
        return redirect()->back()->with(array('status'=>'success','msg'=>$message));
    }
}
