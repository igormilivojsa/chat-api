<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Models\Chat;
use App\Models\User;
use http\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(auth()->user()->load('chats.users'));
    }

    public function create()
    {
        //
    }

    public function store(User $user)
    {
        //
    }

    public function show(Chat $chat)
    {
        return response()->json($chat->messages()->get());
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Chat $chat, User $user)
    {
        $chat->find($chat)->delete();
        return response()->json([
            'message' => 'Chat deleted successfully'
        ]);
    }
}
