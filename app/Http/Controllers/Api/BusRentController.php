<?php

namespace App\Http\Controllers\Api;

use App\Models\BusRent;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusRentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BusRentController extends Controller
{
    public function index() 
    { 
        $busrents = BusRent::latest()->paginate(5); 
 
        return new BusRentResource(true, 'List Data Sewa Bis', $busrents); 
    }

    public function store(Request $request) 
    {  
        $validator = Validator::make($request->all(), [ 
            'customer'  => 'nullable', 
            'phonenumber'  => 'nullable', 
            'busname'  => 'nullable', 
            'longrent'  => 'nullable', 
            'renttype'  => 'nullable', 
            'rentdate'  => 'nullable', 
            'finishedrent'  => 'nullable', 
            'pickuptime'  => 'nullable', 
            'pickuplocation'  => 'nullable', 
            'email'  => 'nullable', 
            'message'  => 'nullable', 
            'status'  => 'nullable', 
        ]); 

        if ($validator->fails()) { 
            return response()->json($validator->errors(), 422); 
        } 
 
        $busrent = BusRent::create([
            'customer'  => $request->customer ?? null,
            'phonenumber'  => $request->phonenumber ?? null,
            'busname'  => $request->busname ?? null,
            'longrent'  => $request->longrent ?? null,
            'bustype'  => $request->bustype ?? null,
            'rentdate'  => $request->rentdate ?? null,
            'finishedrent'  => $request->finishedrent ?? null,
            'departure'  => $request->departure ?? null,
            'email'  => $request->email ?? null,
            'message'  => $request->message ?? null,
            'status'  => $request->status ?? null,
        ]); 
    return new BusRentResource(true, 'Data Sewa Bis Berhasil Ditambahkan!', $busrent); 
    } 

    public function show($id) 
    { 
        $busrent = BusRent::find($id); 
 
        return new BusRentResource(true, 'Detail Data Sewa Bis! ', $busrent); 
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer'  => 'nullable', 
            'phonenumber'  => 'nullable', 
            'busname'  => 'nullable', 
            'longrent'  => 'nullable', 
            'renttype'  => 'nullable', 
            'rentdate'  => 'nullable', 
            'finishedrent'  => 'nullable', 
            'pickuptime'  => 'nullable', 
            'pickuplocation'  => 'nullable', 
            'email'  => 'nullable', 
            'message'  => 'nullable', 
            'status'  => 'nullable', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $busrent = BusRent::find($id);

        $busrent->update([
            'customer'  => $request->customer ?? null,
            'phonenumber'  => $request->phonenumber ?? null,
            'busname'  => $request->busname ?? null,
            'longrent'  => $request->longrent ?? null,
            'bustype'  => $request->bustype ?? null,
            'rentdate'  => $request->rentdate ?? null,
            'finishedrent'  => $request->finishedrent ?? null,
            'departure'  => $request->departure ?? null,
            'email'  => $request->email ?? null,
            'message'  => $request->message ?? null,
            'status'  => $request->status ?? null,
        ]);

        return new BusRentResource(true, 'Data Sewa Bis Berhasil Diubah!', $busrent);
    }

    public function destroy($id)
{
    $busrent = BusRent::find($id);

    $busrent->delete();

    return new BusRentResource(true, 'Data Sewa bis Berhasil Dihapus!', $busrent);
}
}
