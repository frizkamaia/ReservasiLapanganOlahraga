<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatUserController extends Controller
{
    public function index()
    {
        $chats = Chat::where('user_id', Auth::id())->get();
        return view('user.chat.user', compact('chats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pesan' => 'required'
        ]);

        Chat::create([
            'user_id' => Auth::id(),
            'pengirim' => 'user',
            'pesan' => $request->pesan
        ]);

        return back();
    }
}
