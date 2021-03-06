<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function register(Request $request){
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')) 
        ]);
        return $user;
    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'invalid credentials!' 
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24); // 1 day

        return response([
             'message' => $token
            // 'message' => $token
        ])->withCookie($token);
    }

    public function getUser(){
         return User::All();
        // return View('welcome');
    }

    public function PermissionTest(){
        // if (Gate::denies('logged-in')) {
        //     dd('No access');
        // }

        if (Gate::allows('is-admin')) {
            return View('pages.test');
        }
        dd('you need to be admin');
    }
}
