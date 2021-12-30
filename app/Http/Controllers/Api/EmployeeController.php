<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return response() -> json($employee);  
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
            'name'  => 'required|unique:employees|max:255',
            'email'  => 'required',
            'phone'  => 'required|unique:employees',
        ]);

        if ($request -> photo) {
           $postiton = strpos($request -> photo, ';');
           $sub = substr($request -> photo, 0, $postiton);
           $ext = explode('/', $sub)[1];

           $name = time().".". $ext;
           $img = Image::make($request -> photo) -> resize(240,200);
           $upload_path = 'backend/employee/';
           $image_url = $upload_path.$name;
           $img -> save($image_url);

           $employee = Employee::create([
               'name'         => $request -> name, 
               'email'        => $request -> email, 
               'phone'        => $request -> phone, 
               'address'      => $request -> address, 
               'joining_date' => $request -> joining_date, 
               'salary'       => $request -> salary, 
               'nid'          => $request -> nid, 
               'photo'        => $image_url, 
           ]);
        }else{
            $employee = Employee::create([
                'name'         => $request -> name, 
                'email'        => $request -> email, 
                'phone'        => $request -> phone, 
                'address'      => $request -> address, 
                'joining_date' => $request -> joining_date, 
                'salary'       => $request -> salary, 
                'nid'          => $request -> nid, 
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
        $employee = DB::table('employees') -> where('id', $id) -> first();
        // $employee = Employee::find($id);
        return response() -> json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

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
        $data['salary']  = $request -> salary;
        $data['address']  = $request -> address;
        $data['nid']  = $request -> nid;
        $data['joining_date']  = $request -> joining_date;

        $image = $request -> newphoto;
        if($image){
            $postiton = strpos($image, ';');
           $sub = substr($image, 0, $postiton);
           $ext = explode('/', $sub)[1];

           $name = time().".". $ext;
           $img = Image::make($image) -> resize(240,200);
           $upload_path = 'backend/employee/';
           $image_url = $upload_path.$name;
           $success = $img -> save($image_url);

           if ($success) {
               $data['photo'] = $image_url;
               $img = DB::table('employees') -> where('id', $id) -> first();
               $image_path = $img -> photo;
               unlink($image_path);
               DB::table('employees') -> where('id', $id) -> update($data);
           }
        }else{
            $oldphoto = $request -> photo;
            $data['photo'] = $oldphoto;
            DB::table('employees') -> where('id', $id) -> update($data);
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
        $employee = DB::table('employees') -> where('id', $id) -> first();
        $photo = $employee -> photo;
        if($photo){
            unlink($photo);
            DB::table('employees') -> where('id', $id) -> delete();
        }else{
            DB::table('employees') -> where('id', $id) -> delete();
        }
        
    }
}
