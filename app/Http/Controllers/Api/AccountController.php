<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index() 
    { 
        $accounts = Account::latest()->paginate(5); 
 
        return new AccountResource(true, 'List Data Akun', $accounts); 
    }

    public function store(Request $request) 
    {  
        $validator = Validator::make($request->all(), [  
            'email'  => 'nullable', 
            'password'  => 'nullable', 
            'username'  => 'nullable', 
        ]); 

        if ($validator->fails()) { 
            return response()->json($validator->errors(), 422); 
        } 
 
        $account = Account::create([
            'email'  => $request->email ?? null,
            'password'  => $request->password ?? null,
            'username'  => $request->username ?? null,
        ]); 
    return new AccountResource(true, 'Akun Berhasil Ditambahkan!', $account); 
    } 

    public function show($id) 
    { 
        $account = Account::find($id); 
 
        return new AccountResource(true, 'Detail Data Akun! ', $account); 
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email'  => 'nullable', 
            'password'  => 'nullable', 
            'username'  => 'nullable', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $account = Account::find($id);

        $account->update([
            'email'  => $request->email ?? null,
            'password'  => $request->password ?? null,
            'username'  => $request->username ?? null,
        ]);

        return new AccountResource(true, 'Data Akun Berhasil Diubah!', $account);
    }

    public function destroy($id)
{
    $account = Account::find($id);

    $account->delete();

    return new AccountResource(true, 'Data Akun Berhasil Dihapus!', $account);
}
}
