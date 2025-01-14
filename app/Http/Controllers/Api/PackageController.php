<?php

namespace App\Http\Controllers\Api;

use App\Models\Package;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index() 
    { 
        $packages = Package::latest()->paginate(5); 
 
        return new PackageResource(true, 'List Data Paket', $packages); 
    }

    public function store(Request $request) 
    {  
        $validator = Validator::make($request->all(), [ 
            'name'          => 'required',
            'image1'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
            'image2'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
            'image3'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
            'destination1'  => 'nullable', 
            'destination2'  => 'nullable', 
            'destination3'  => 'nullable', 
            'destination4'  => 'nullable', 
            'destination5'  => 'nullable', 
            'destination6'  => 'nullable', 
            'destination7'  => 'nullable', 
            'destination8'  => 'nullable', 
            'price'         => 'required', 
            'content'       => 'required',
            'status'       => 'required', 
        ]); 

        if ($validator->fails()) { 
            return response()->json($validator->errors(), 422); 
        } 
 
        $image1 = $request->file('image1'); 
        $image2 = $request->file('image2'); 
        $image3 = $request->file('image3'); 
        $image1->storeAs('public/packages', $image1->hashName()); 
        $image2->storeAs('public/packages', $image2->hashName()); 
        $image3->storeAs('public/packages', $image3->hashName()); 
 
        $package = Package::create([
            'name'          => $request->name,
            'image1'        => $image1 ? $image1->hashName() : null,
            'image2'        => $image2 ? $image2->hashName() : null,
            'image3'        => $image3 ? $image3->hashName() : null,
            'destination1'  => $request->destination1,
            'destination2'  => $request->destination2 ?? null,
            'destination3'  => $request->destination3 ?? null,
            'destination4'  => $request->destination4 ?? null,
            'destination5'  => $request->destination5 ?? null,
            'destination6'  => $request->destination6 ?? null,
            'destination7'  => $request->destination7 ?? null,
            'destination8'  => $request->destination8 ?? null,
            'price'         => $request->price,
            'content'       => $request->content,
            'status'       => $request->status,
        ]); 
    return new PackageResource(true, 'Data Paket Berhasil Ditambahkan!', $package); 
    } 

    public function show($id) 
    { 
        $package = Package::find($id); 
 
        return new PackageResource(true, 'Detail Data Paket! ', $package); 
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required', 
            'destination1'  => 'nullable', 
            'destination2'  => 'nullable', 
            'destination3'  => 'nullable', 
            'destination4'  => 'nullable', 
            'destination5'  => 'nullable', 
            'destination6'  => 'nullable', 
            'destination7'  => 'nullable', 
            'destination8'  => 'nullable', 
            'price'         => 'required', 
            'content'       => 'required',
            'status'       => 'required', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $package = Package::find($id);

        if ($request->hasFile('image1')) {

            $image1 = $request->file('image1');
            $image1->storeAs('public/packages', $image1->hashName());

            Storage::delete('public/packages/' . basename($package->image1));

            $package->update([
                'name'          => $request->name,
                'image1'        => $image1 ? $image1->hashName() : null,
                'image2'        => $image2 ? $image2->hashName() : null,
                'image3'        => $image3 ? $image3->hashName() : null,
                'destination1'  => $request->destination1,
                'destination2'  => $request->destination2 ?? null,
                'destination3'  => $request->destination3 ?? null,
                'destination4'  => $request->destination4 ?? null,
                'destination5'  => $request->destination5 ?? null,
                'destination6'  => $request->destination6 ?? null,
                'destination7'  => $request->destination7 ?? null,
                'destination8'  => $request->destination8 ?? null,
                'price'         => $request->price,
                'content'       => $request->content,
                'status'       => $request->status,
            ]);
        } else {

            $package->update([
                'name'          => $request->name,
                'destination1'  => $request->destination1,
                'destination2'  => $request->destination2 ?? null,
                'destination3'  => $request->destination3 ?? null,
                'destination4'  => $request->destination4 ?? null,
                'destination5'  => $request->destination5 ?? null,
                'destination6'  => $request->destination6 ?? null,
                'destination7'  => $request->destination7 ?? null,
                'destination8'  => $request->destination8 ?? null,
                'price'         => $request->price,
                'content'       => $request->content,
                'status'       => $request->status,
            ]);
        }

        return new PackageResource(true, 'Data Paket Berhasil Diubah!', $package);
    }

    public function destroy($id)
{
    $package = Package::find($id);

    if ($package) {
        // Delete images if they exist
        if ($package->image1) {
            Storage::delete('public/packages/' . $package->image1);
        }
        if ($package->image2) {
            Storage::delete('public/packages/' . $package->image2);
        }
        if ($package->image3) {
            Storage::delete('public/packages/' . $package->image3);
        }

        // Delete the package record
        $package->delete();

        return new PackageResource(true, 'Data Paket Berhasil Dihapus!', null);
    }

    return response()->json(['message' => 'Package not found'], 404);
}
}
