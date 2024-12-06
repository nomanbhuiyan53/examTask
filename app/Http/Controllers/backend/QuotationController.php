<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index(){
        $clients = Client::all();
        return view('backend.quotation.quotation', compact('clients'));
    }

    public function table(){
        $quotation = Quotation::with('client')->get();
        return response()->json($quotation);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'client_id' => 'required',
            'date' => 'required',
            'total_amount' => 'required',
        ]);
        if ($request->quotation_id){
            $quotation = Quotation::findOrFail($request->quotation_id);
            $quotation->client_id = $request->client_id;
            $quotation->date = $request->date;
            $quotation->total_amount = $request->total_amount;
            $quotation->status = $request->status;
            $quotation->save();
        }else{
            $quotation = new Quotation();
            $quotation->client_id = $request->client_id;
            $quotation->date = $request->date;
            $quotation->total_amount = $request->total_amount;
            $quotation->status = $request->status;
            $quotation->save();
            return response()->json($quotation);
        }
        
    }

    public function edit($id){
        $quotation = Quotation::with('client')->findOrFail($id);
        return response()->json($quotation);
    }

    public function destroy($id){
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();
        return response()->json(['message' => 'Quotation deleted successfully']);
    }

    public function quotationDetails(){
        $products = Product::all();
        $quotations = Quotation::all();
        return view('backend.quotation.quotation_details', compact('products', 'quotations'));
    }

    public function quotationDetailsTable(){
        $quotationDetails = QuotationDetail::with('product','quotation')->get();
        return response()->json($quotationDetails);
    }

    public function quotationDetailsStore(Request $request){
       
        $validated = $request->validate([
            'quotation_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);
        if ($request->details_id){
            $quotationDetail = QuotationDetail::findOrFail($request->details_id);
            $quotationDetail->quotation_id = $request->quotation_id;
            $quotationDetail->product_id = $request->product_id;
            $quotationDetail->quantity = $request->quantity;
            $quotationDetail->unit_price = $request->unit_price;
            $quotationDetail->total_price = $request->total_price;
            $quotationDetail->details = $request->details;
            $quotationDetail->update();
        }else{
            $quotationDetail = new QuotationDetail();
            $quotationDetail->quotation_id = $request->quotation_id;
            $quotationDetail->product_id = $request->product_id;
            $quotationDetail->quantity = $request->quantity;
            $quotationDetail->unit_price = $request->unit_price;
            $quotationDetail->total_price = $request->total_price;
            $quotationDetail->details = $request->details;
            $quotationDetail->save();  
        }
        
        return response()->json($quotationDetail);
    }

    public function quotationDetailsEdit($id){
        $quotationDetail = QuotationDetail::with('product','quotation')->findOrFail($id);
        return response()->json($quotationDetail);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function quotationDetailsDelete($id){
        $quotationDetail = QuotationDetail::findOrFail($id);
        $quotationDetail->delete();
        return response()->json(['message' => 'Quotation Detail deleted successfully']);
    }
}
