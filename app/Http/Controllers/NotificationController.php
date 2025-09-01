<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class NotificationController extends Controller
{
    public function saveToken(Request $request)
    {
        $request->validate(['token' => 'required|string']);
        $user = $request->user();
        $user->fcm_token = $request->token;
        $user->save();
        return response()->json(['message' => 'Token saved']);
    }

    public function notify(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required',
            'body' => 'required'
        ]);

        $user = User::find($request->user_id);
        if ($user && $user->fcm_token) {
            Http::withToken(env('FIREBASE_SERVER_KEY'))
                ->post('https://fcm.googleapis.com/fcm/send', [
                    'to' => $user->fcm_token,
                    'notification' => [
                        'title' => $request->title,
                        'body' => $request->body
                    ]
                ]);
        }

        return response()->json(['message' => 'Notification sent']);
    }
}
