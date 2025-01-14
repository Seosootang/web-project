<?php

namespace App\Http\Controllers\Api;

use App\Models\CarRent;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarRentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CarRentController extends Controller
{
    public function index() 
    { 
        $carrents = CarRent::latest()->paginate(5); 
 
        return new CarRentResource(true, 'List Data Sewa Mobil', $carrents); 
    }

    public function store(Request $request) 
    {  
        $validator = Validator::make($request->all(), [ 
            'customer'  => 'nullable',
            'phonenumber'  => 'nullable', 
            'carname'  => 'nullable', 
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
 
        $carrent = CarRent::create([
            'customer'  => $request->customer ?? null,
            'phonenumber'  => $request->phonenumber ?? null,
            'carname'  => $request->carname ?? null,
            'longrent'  => $request->longrent ?? null,
            'renttype'  => $request->renttype ?? null,
            'rentdate'  => $request->rentdate ?? null,
            'finishedrent'  => $request->finishedrent ?? null,
            'pickuptime'  => $request->pickuptime ?? null,
            'pickuplocation'  => $request->pickuplocation ?? null,
            'email'  => $request->email ?? null,
            'message'  => $request->message ?? null,
            'status'  => $request->status ?? null,
        ]); 
    return new CarRentResource(true, 'Data Sewa Mobil Berhasil Ditambahkan!', $carrent); 
    } 

    public function show($id) 
    { 
        $carrent = CarRent::find($id); 
 
        return new CarRentResource(true, 'Detail Data Sewa Mobil! ', $carrent); 
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer'  => 'nullable',
            'phonenumber'  => 'nullable', 
            'carname'  => 'nullable', 
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

        $carrent = CarRent::find($id);

        $carrent->update([
            'customer'  => $request->customer ?? null,
            'phonenumber'  => $request->phonenumber ?? null,
            'carname'  => $request->carname ?? null,
            'longrent'  => $request->longrent ?? null,
            'renttype'  => $request->renttype ?? null,
            'rentdate'  => $request->rentdate ?? null,
            'finishedrent'  => $request->finishedrent ?? null,
            'pickuptime'  => $request->pickuptime ?? null,
            'pickuplocation'  => $request->pickuplocation ?? null,
            'email'  => $request->email ?? null,
            'message'  => $request->message ?? null,
            'status'  => $request->status ?? null,
        ]);

        return new CarRentResource(true, 'Data Sewa Mobil Berhasil Diubah!', $carrent);
    }

    public function destroy($id)
{
    $carrent = CarRent::find($id);

    $carrent->delete();

    return new CarRentResource(true, 'Data Sewa Mobil Berhasil Dihapus!', $carrent);
}
}
