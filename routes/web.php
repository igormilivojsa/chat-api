<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return User::find(1)->chats;
});
