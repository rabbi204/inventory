<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Claims\Custom;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = DB::table('customers') -> orderBy('id','DESC') -> get();
        return response() -> json($customer);  
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
        $validateData = $request -> validate([
            'name'  => 'required|unique:customers|max:255',
            'email'  => 'required',
            'phone'  => 'required|unique:customers',
        ]);

        if ($request -> photo) {
           $postiton = strpos($request -> photo, ';');
           $sub = substr($request -> photo, 0, $postiton);
           $ext = explode('/', $sub)[1];

           $name = time().".". $ext;
           $img = Image::make($request -> photo) -> resize(240,200);
           $upload_path = 'backend/customer/';
           $image_url = $upload_path.$name;
           $img -> save($image_url);

           $employee = Customer::create([
               'name'         => $request -> name, 
               'email'        => $request -> email, 
               'phone'        => $request -> phone, 
               'address'      => $request -> address,
               'photo'        => $image_url, 
           ]);
        }else{
            $employee = Customer::create([
                'name'         => $request -> name, 
                'email'        => $request -> email, 
                'phone'        => $request -> phone, 
                'address'      => $request -> address, 
            ]);
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
        $customer = DB::table('customers') -> where('id', $id) -> first();
        // $customer = Customer::find($id);
        return response() -> json($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data['name']  = $request -> name;
        $data['email']  = $request -> email;
        $data['phone']  = $request -> phone;
        $data['address']  = $request -> address;

        $image = $request -> newphoto;
        if($image){
            $postiton = strpos($image, ';');
           $sub = substr($image, 0, $postiton);
           $ext = explode('/', $sub)[1];

           $name = time().".". $ext;
           $img = Image::make($image) -> resize(240,200);
           $upload_path = 'backend/customer/';
           $image_url = $upload_path.$name;
           $success = $img -> save($image_url);

           if ($success) {
               $data['photo'] = $image_url;
               $img = DB::table('customers') -> where('id', $id) -> first();
               $image_path = $img -> photo;
               unlink($image_path);
               DB::table('customers') -> where('id', $id) -> update($data);
           }
        }else{
            $oldphoto = $request -> photo;
            $data['photo'] = $oldphoto;
            DB::table('customers') -> where('id', $id) -> update($data);
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
        $customer = DB::table('customers') -> where('id', $id) -> first();
        $photo = $customer -> photo;
        if($photo){
            unlink($photo);
            DB::table('customers') -> where('id', $id) -> delete();
        }else{
            DB::table('customers') -> where('id', $id) -> delete();
        }
    }
}
