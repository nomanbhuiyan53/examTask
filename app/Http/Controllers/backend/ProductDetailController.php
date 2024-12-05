<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function index($productId)
    {
        $productDetails = ProductDetail::with('product')->where('product_id', $productId)->get();
        $productId = Product::all();
        return view('backend.product.product_details', compact('productDetails', 'productId'));
    }

    // Create a new product detail
    public function store(Request $request, $productId)
    {
        $request->validate([
            'detail_name' => 'required|string|max:255',
            'detail_value' => 'required|string|max:255',
        ]);

        $productDetail = new ProductDetail();
        $productDetail->product_id = $productId;
        $productDetail->detail_name = $request->detail_name;
        $productDetail->detail_value = $request->detail_value;
        $productDetail->save();

        return response()->json($productDetail, 201);
    }

    // Update a product detail
    public function update(Request $request, $id)
    {
        $request->validate([
            'detail_name' => 'required|string|max:255',
            'detail_value' => 'required|string|max:255',
        ]);

        $productDetail = ProductDetail::findOrFail($id);
        $productDetail->detail_name = $request->detail_name;
        $productDetail->detail_value = $request->detail_value;
        $productDetail->save();

        return response()->json($productDetail);
    }

    // Delete a product detail
    public function destroy($id)
    {
        $productDetail = ProductDetail::findOrFail($id);
        $productDetail->delete();

        return response()->json(['message' => 'Product detail deleted successfully']);
    }
}
