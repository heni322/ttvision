<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $token = $request->bearerToken();
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $roles = $user->getRoleNames();
        // $token = Auth::getToken();
        return response()->json(["access_token" => $token, "role" => $roles[0]], 200);
    }
}
