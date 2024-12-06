<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function index()
    {
        $productDetails = ProductDetail::with('product')->get();
        $products = Product::all();
        return view('backend.product.product_details', compact('productDetails', 'products'));
    }

    public function table(){
        $productDetails = ProductDetail::with('product')->get();
        return response()->json($productDetails);
    }
    // Create a new product detail
    public function store(Request $request)
    {

        $request->validate([
            'detail_name' => 'required|string|max:255',
            'detail_value' => 'required|string|max:255',
        ]);
        if($request->productId){
            $productDetail = ProductDetail::findOrFail($request->productId);
            $productDetail->product_id = $request->product_id;
            $productDetail->detail_name = $request->detail_name;
            $productDetail->detail_value = $request->detail_value;
            $productDetail->update();
        }else{
            $productDetail = new ProductDetail();
            $productDetail->product_id = $request->product_id;
            $productDetail->detail_name = $request->detail_name;
            $productDetail->detail_value = $request->detail_value;
            $productDetail->save();
        }
        return response()->json($productDetail, 201);
    }

    public function edit($id) {
        $productDetail = ProductDetail::findOrFail($id);
        $products = Product::all();
        return response()->json(['productDetail' => $productDetail, 'products' => $products]);
    }

    // Delete a product detail
    public function destroy($id)
    {
        $productDetail = ProductDetail::findOrFail($id);
        $productDetail->delete();

        return response()->json(['message' => 'Product detail deleted successfully']);
    }
}
