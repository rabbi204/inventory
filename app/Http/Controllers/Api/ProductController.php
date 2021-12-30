<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product= DB::table('products')
                    -> join('categories', 'products.category_id', 'categories.id')
                    -> join('suppliers', 'products.supplier_id', 'suppliers.id')
                    -> select('categories.category_name', 'suppliers.name', 'products.*')
                    -> orderBy('products.id', 'DESC')
                    -> get();
        return response() -> json($product);
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
            'product_name'  => 'required|max:255',
            'product_code'  => 'required|unique:products|max:255',
            'root'  => 'required',
            'category_id'  => 'required',
            'supplier_id'  => 'required',
            'buying_price'  => 'required',
            'selling_price'  => 'required',
            'buying_date'  => 'required',
            'product_quantity'  => 'required',
        ]);

        if ($request -> image) {
            $postiton = strpos($request -> image, ';');
            $sub = substr($request -> image, 0, $postiton);
            $ext = explode('/', $sub)[1];
 
            $name = time().".". $ext;
            $img = Image::make($request -> image) -> resize(240,200);
            $upload_path = 'backend/product/';
            $image_url = $upload_path.$name;
            $img -> save($image_url);
 
            $product = Product::create([
                'product_name'         => $request -> product_name, 
                'product_code'         => $request -> product_code, 
                'root'                 => $request -> root, 
                'category_id'          => $request -> category_id, 
                'supplier_id'          => $request -> supplier_id, 
                'buying_price'         => $request -> buying_price, 
                'selling_price'        => $request -> selling_price, 
                'buying_date'          => $request -> buying_date, 
                'product_quantity'     => $request -> product_quantity, 
                'image'                => $image_url, 
            ]);
         }else{
             $product = Product::create([
                'product_name'         => $request -> product_name, 
                'product_code'         => $request -> product_code, 
                'root'                 => $request -> root, 
                'category_id'          => $request -> category_id, 
                'supplier_id'          => $request -> supplier_id, 
                'buying_price'         => $request -> buying_price, 
                'selling_price'        => $request -> selling_price, 
                'buying_date'          => $request -> buying_date, 
                'product_quantity'     => $request -> product_quantity
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
        $product = DB::table('products') -> where('id', $id) -> first();
        // $employee = Employee::find($id);
        return response() -> json($product);
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
        $data['product_name']  = $request -> product_name;
        $data['product_code']  = $request -> product_code;
        $data['category_id']  = $request -> category_id;
        $data['supplier_id']  = $request -> supplier_id;
        $data['root']  = $request -> root;
        $data['buying_price']  = $request -> buying_price;
        $data['selling_price']  = $request -> selling_price;
        $data['product_quantity']  = $request -> selling_price;

        $image = $request -> newimage;
        if($image){
            $postiton = strpos($image, ';');
           $sub = substr($image, 0, $postiton);
           $ext = explode('/', $sub)[1];

           $name = time().".". $ext;
           $img = Image::make($image) -> resize(240,200);
           $upload_path = 'backend/product/';
           $image_url = $upload_path.$name;
           $success = $img -> save($image_url);

           if ($success) {
               $data['image'] = $image_url;
               $img = DB::table('products') -> where('id', $id) -> first();
               $image_path = $img -> image;
               unlink($image_path);
               DB::table('products') -> where('id', $id) -> update($data);
           }
        }else{
            $oldphoto = $request -> image;
            $data['image'] = $oldphoto;
            DB::table('products') -> where('id', $id) -> update($data);
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
        $product = DB::table('products') -> where('id', $id) -> first();
        $photo = $product -> image;
        if($photo){
            unlink($photo);
            DB::table('products') -> where('id', $id) -> delete();
        }else{
            DB::table('products') -> where('id', $id) -> delete();
        }
    }
}
