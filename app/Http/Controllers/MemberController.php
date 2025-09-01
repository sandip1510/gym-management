<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'membership' => null,
            'stats' => [
                'workouts_this_week' => 0,
                'streak_days' => 0
            ]
        ]);
    }
}
