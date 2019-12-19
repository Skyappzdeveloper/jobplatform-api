<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Resources\Product as ProductResource;
use Response;
use \Illuminate\Http\Response as Res;

class ProductController extends Controller {
    //
    public function user(){
        $user = Product::get();
        return $this->respond([
                'status' => 'success',
                'message' => $user,

            ]);
        //return new ProductResource(Product::find($id));
    }

    public function respond($data, $headers = []){

        return Response::json($data, Res::HTTP_OK, $headers);

    }
}
