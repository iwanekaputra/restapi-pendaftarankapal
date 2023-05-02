<?php

namespace App\Http\Controllers;

use App\Models\Kapal;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function notificationVerifiedUser () {
        $user = User::where('isVerified', false)->get();

        return response()->json([
            'data' => $user
        ]);
    }

    public function verifiedUser ($id) {
        $user = User::where('id', $id)->first();
        if($user) {
            $user->update([
                'isVerified' => true
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'berhasil konfirmasi user dari admin'
        ]);
    }

    public function verifyKapal($id) {
        $kapal = Kapal::where('id', $id)->first();

        if($kapal) {
            $kapal->update([
                'isVerifiedAdmin' => 1
            ]);

            return response()->json([
                'message' => 'sudah diterima admin'
            ]);
        }
    }
}
