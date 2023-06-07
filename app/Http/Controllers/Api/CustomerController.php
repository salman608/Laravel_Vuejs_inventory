<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::latest()->get();
        return response()->json($customer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'customer_name' => 'required|unique:customers|max:255',
            'customer_email' => 'required',
            'customer_phone' => 'required|unique:customers',

        ]);

        if ($request->customer_photo) {
            $position = strpos($request->customer_photo, ';');
            $sub = substr($request->customer_photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($request->customer_photo)->resize(240, 200);
            $upload_path = 'backend/customer/';
            $image_url = $upload_path . $name;
            $img->save($image_url);

            $customer = new Customer();
            $customer->customer_name = $request->customer_name;
            $customer->customer_email = $request->customer_email;
            $customer->customer_phone = $request->customer_phone;
            $customer->customer_address = $request->customer_address;
            $customer->customer_photo = $image_url;
            $customer->save();
        } else {
            $customer = new Customer();
            $customer->customer_name = $request->customer_name;
            $customer->customer_email = $request->customer_email;
            $customer->customer_phone = $request->customer_phone;
            $customer->customer_address = $request->customer_address;

            $customer->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
        return response()->json($customer);
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
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_address'] = $request->customer_address;

        $image = $request->newphoto;

        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_path = 'backend/customer/';
            $image_url = $upload_path . $name;
            $success = $img->save($image_url);

            if ($success) {
                $data['customer_photo'] = $image_url;
                $img = DB::table('customers')->where('id', $id)->first();
                $image_path = $img->customer_photo;
                unlink($image_path);
                $user = DB::table('customers')->where('id', $id)->update($data);
            }
        } else {
            $oldphoto = $request->customer_photo;
            $data['customer_photo'] = $oldphoto;
            DB::table('customers')->where('id', $id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
        $customer_photo = $customer->customer_photo;
        if ($customer_photo) {
            unlink($customer_photo);
            DB::table('customers')->where('id', $id)->delete();
        } else {
            DB::table('customers')->where('id', $id)->delete();
        }
    }
}
