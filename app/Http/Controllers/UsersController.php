<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    return view('admin.users.index', [
        'users' => User::withCount('reservasi')->latest()->get()
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama'  => 'required',
        'email' => 'required|email|unique:user,email',
        'role'  => 'required',
    ]);

    User::create([
        'nama'     => $request->nama, // ✅ FIX
        'email'    => $request->email,
        'password' => Hash::make('password'), // default
        'role'     => $request->role, // ✅ WAJIB
    ]);

    return redirect()->route('admin.users.index')
        ->with('success', 'User berhasil ditambahkan');
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
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama'  => 'required',
            'email' => 'required|email|unique:user,email,' . $user->id,
        ]);

        $user->update($request->only('nama', 'email'));

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User dihapus');
    }
}
