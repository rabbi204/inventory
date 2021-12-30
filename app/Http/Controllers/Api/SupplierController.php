<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();
        return response() -> json($supplier);
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
            'name'  => 'required|unique:suppliers|max:255',
            'email' => 'required',
            'phone' => 'required|unique:suppliers'
        ]);

        if($request -> photo){
            $postion = strpos($request-> photo, ';');
            $sub = substr($request -> photo, 0, $postion);
            $ext = explode('/',$sub)[1];

            $name = time().'.'.$ext;
            $img = Image::make($request -> photo) -> resize(230,200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path.$name;
            $img -> save($image_url); 
            $supplier = Supplier::create([
                'name'          => $request -> name,
                'email'         => $request -> email,
                'phone'         => $request -> phone,
                'address'       => $request -> address,
                'shopname'      => $request -> shopname,
                'photo'         => $image_url
            ]);
        }else{
            $supplier = Supplier::create([
                'name'          => $request -> name,
                'email'         => $request -> email,
                'phone'         => $request -> phone,
                'address'       => $request -> address,
                'shopname'      => $request -> shopname
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
        $supplier = DB::table('suppliers') -> where('id',$id) -> first();
        return response() -> json($supplier);
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
        $data['name'] = $request -> name;
        $data['email'] = $request -> email;
        $data['phone'] = $request -> phone;
        $data['address'] = $request -> address;
        $data['shopname'] = $request -> shopname;
        $image = $request -> newphoto;

        if($image){
            $postion = strpos($image, ';');
            $sub = substr($image, 0, $postion);
            $ext = explode('/', $sub)[1];

            $name = time().'.'.$ext;
            $img = Image::make($image) -> resize(240, 200);
            $upload_path = 'backend/supplier/';
            $image_url = $upload_path.$name;
            $success = $img -> save($image_url);
            if($success){
                $data['photo'] = $image_url;
                $img = DB::table('suppliers') -> where('id', $id) -> first();
                $image_path = $img -> photo;
                unlink($image_path);
                DB::table('suppliers') -> where('id', $id) -> update($data);
            }
        }else{
            $oldphoto = $request -> photo;
            $data['photo'] = $oldphoto;
            DB::table('suppliers') -> where('id', $id) -> update($data);
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
        $supplier = Supplier::find($id);
        $photo = $supplier -> photo;
        if($photo){
            unlink($photo);
            Supplier::find($id) -> delete();
        }else{
            Supplier::find($id) -> delete();
        }
    }
}
