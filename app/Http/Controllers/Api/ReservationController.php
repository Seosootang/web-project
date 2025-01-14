<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    public function index() 
    { 
        $reservations = Reservation::latest()->paginate(5); 
 
        return new ReservationResource(true, 'List Data Reservasi', $reservations); 
    }

    public function store(Request $request) 
    {  
        $validator = Validator::make($request->all(), [ 
            'customer'  => 'nullable', 
            'packagechoice'  => 'nullable', 
            'date'  => 'nullable', 
            'pickup'  => 'nullable', 
            'email'  => 'nullable', 
            'phonenumber'  => 'nullable',
            'status'  => 'nullable',
        ]); 

        if ($validator->fails()) { 
            return response()->json($validator->errors(), 422); 
        } 
 
        $reservation = Reservation::create([
            'customer'  => $request->customer ?? null,
            'packagechoice'  => $request->packagechoice ?? null,
            'date'  => $request->date ?? null,
            'pickup'  => $request->pickup ?? null,
            'email'  => $request->email ?? null,
            'phonenumber'  => $request->phonenumber ?? null,
            'status'  => $request->status ?? null,
        ]); 
    return new ReservationResource(true, 'Data Reservasi Berhasil Ditambahkan!', $reservation); 
    } 

    public function show($id) 
    { 
        $reservation = Reservation::find($id); 
 
        return new ReservationResource(true, 'Detail Data Reservasi! ', $reservation); 
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer'  => 'nullable', 
            'packagechoice'  => 'nullable', 
            'date'  => 'nullable', 
            'pickup'  => 'nullable', 
            'email'  => 'nullable', 
            'phonenumber'  => 'nullable', 
            'status'  => 'nullable', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reservation = Reservation::find($id);

        $reservation->update([
            'customer'  => $request->customer ?? null,
            'packagechoice'  => $request->packagechoice ?? null,
            'date'  => $request->date ?? null,
            'pickup'  => $request->pickup ?? null,
            'email'  => $request->email ?? null,
            'phonenumber'  => $request->phonenumber ?? null,
            'status'  => $request->status ?? null,
        ]);

        return new ReservationResource(true, 'Data Reservasi Berhasil Diubah!', $reservation);
    }

    public function destroy($id)
{
    $reservation = Reservation::find($id);

    $reservation->delete();

    return new ReservationResource(true, 'Data Reservasi Berhasil Dihapus!', $reservation);
}
}
