<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();
        return view('pages.user.index', [
            'title' => 'Management User',
            'menu' => 'Management User',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.create', [
            'title' => 'Management User',
            'menu' => 'Management User',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'role' => 'required|in:Pengguna,Administrator,Pengelola',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('spk/destinasi/user.index')->with('success', 'Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = User::find(decrypt($id));
        return view('pages.user.edit', [
            'title' => 'Management User',
            'menu' => 'Management User',
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();    
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable',
            'role' => 'required|in:Pengguna,Administrator,Pengelola',
        ]);
            
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ];
        
        if ($request->password != null) {
            $request->validate([
                'password' => 'required|min:8'
            ]);
            $data['password'] = $request->password;
        }
        $item = User::find(decrypt($id));
        $item->update($data);
        
        return redirect()->route('spk/destinasi/user.index')->with('success', 'Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = User::find(decrypt($id));
        $item->delete();

        return back()->with('success', 'Berhasil Dihapus');
    }
}
