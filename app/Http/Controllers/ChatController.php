<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(User $user): JsonResponse
    {
        return response()->json($user->load('chats.users'));
    }

    public function create()
    {
        //
    }

    public function store(User $user)
    {
        if (auth()->user()->hasChatWith($user) == false) {
            $chat = Chat::create();

            auth()->user()->chats()->attach($chat);
            $user->chats()->attach($chat);

            return response()->json([
                'message' => 'chat created'
            ]);
        } else {
            return response()->json([
                'message' => __('The chat alredy exists!'),
            ]);
        }
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

    public function destroy(User $user)
    {
        if (auth()->user()->hasChatWith($user) == true) {
            auth()->user()->chats()->find($chat)->delete();
        } else {
            return response()->json([
                'message' => _('Chat doesnt exists')
            ]);
        }

    }
}
