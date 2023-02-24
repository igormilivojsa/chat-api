<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user): JsonResponse
    {
        return response()->json(auth()->user()->friendss());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(User $user): JsonResponse
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => __('The user cannot follow himself!'),
            ]);
        }

        if (! auth()->user()->isFriends($user)) {
            auth()->user()->follow($user);

            return response()->json([
                'message' => __('The follow was successful!'),
            ]);
        }

        return response()->json([
            'message' => __('The user is already following this user!'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function show(Friend $friend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friend $friend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) : JsonResponse
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => __('The user can not  unfollow himself!'),
            ]);
        }

        if (auth()->user()->isFriends($user)) {
            auth()->user()->unfollow($user);

            return response()->json([
                'message' => __('The unfollow was successful!'),
            ]);
        }

        return response()->json([
            'message' => __('The user is not friend with this user'),
        ]);
    }
}
