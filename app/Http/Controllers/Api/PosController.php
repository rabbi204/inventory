<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    //get data
    public function getProduct($id)
    {
        $product = DB::table('products') 
                    -> where('category_id', $id)
                    -> get();
        return response() -> json($product);
    }
}
