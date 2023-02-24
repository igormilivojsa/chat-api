<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(User $user)
    {
        return response($user->load('chats.users'));
    }

    public function create()
    {
        //
    }

    public function store(User $user)
    {
        $chat = Chat::create();

        auth()->user()->chats()->attach($chat);
        $user->chats()->attach($chat);

        return response('chat created');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
