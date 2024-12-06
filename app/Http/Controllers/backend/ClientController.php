<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index()
    {
        $clients = Client::all();

        return view('backend.client.index', compact('clients'));
    }
    public function table()
    {
        $clients = Client::all();

        return response()->json($clients);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:10',
        ]);
        if ($request->clientId){
            $client = Client::findOrFail($request->clientId);
            $client->name = $request->name;
            $client->email = $request->email;
            $client->phone = $request->phone;
            $client->address = $request->address;
            $client->update();
        }else{
            $client = new Client();
            $client->name = $request->name;
            $client->email = $request->email;
            $client->phone = $request->phone;
            $client->address = $request->address;
            $client->save();
        }
        return response()->json($client);
    }
    public function edit($id)
    {
        $client = Client::find($id);
        return response()->json($client);
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json(['message' => 'client deleted successfully']);
    }
}


