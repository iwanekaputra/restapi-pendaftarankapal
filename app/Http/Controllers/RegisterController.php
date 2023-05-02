<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;
use Spatie\Permission\Models\Permission;







class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $token = Str::random(6);

        //create user
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'token_activation' => $token,
            'isVefified' => false
        ]);

        $permission1 = Permission::findOrFail(1);
        $permission2 = Permission::findOrFail(2);

        $user->givePermissionTo([$permission1, $permission2]);

        Mail::send('emailVerificationEmail', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Email Verification Mail');
        });
        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'message' => 'silahkan berikan kode otp yang dikirimkan melalui email'
            ], 201);
        }


        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }


    public function verifyAccount($token)
    {
        $user = User::where('token_activation', $token)->first();

        if($user) {
            return redirect()->route('success');
        }
    }


    public function otp(Request $request) {
        $user = User::where('token_activation', $request->otp)->first();
        if($user) {
            $user->update([
                'email_verified_at' => 1
            ]);

            return response()->json([
                'message' => 'berhasil'
            ]);
        }

        return response()->json([
            'message' => 'otp not valid'
        ]);




    }

}
