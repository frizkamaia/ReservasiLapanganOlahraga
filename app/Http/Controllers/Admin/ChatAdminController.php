<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatAdminController extends Controller
{
    // ===============================
    // LIST USER YANG PERNAH CHAT
    // ===============================
    public function index()
    {
        $users = Chat::with('user')
            ->select('user_id')
            ->groupBy('user_id')
            ->get();

        return view('admin.chat.index', compact('users'));
    }

    // ===============================
    // DETAIL CHAT DENGAN 1 USER
    // ===============================
    public function show($userId)
    {
        $user = User::findOrFail($userId);

        $messages = Chat::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.chat.show', compact('user', 'messages'));
    }

    // ===============================
    // ADMIN BALAS CHAT
    // ===============================
    public function reply(Request $request, $userId)
    {
        $request->validate([
            'pesan' => 'required|string'
        ]);

        Chat::create([
            'user_id' => $userId,
            'pengirim' => 'admin',
            'pesan' => $request->pesan
        ]);

        return redirect()->route('admin.chat.show', $userId);
    }
}
