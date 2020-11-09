<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    function register(Request $request)
    {
        $valid = validator($request->only('email', 'name', 'password'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);
            return response()->json($jsonError);
        }
        $data = request()->only('email', 'name', 'password');
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $objToken = $user->createToken('Nobis', ['user']);
        $success['token'] = $objToken->accessToken;
        return response()->json($objToken->accessToken, 200);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    function signin(Request $request)
    {
        $data = $request->only('email', 'password');
        $validator = validator($data, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 417);
        }
        $email = $data['email'];
        $password = $data['password'];
        $user = User::Where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (Hash::check($password, $user->password)) // Auth::attempt(['email' => request('email'), 'password' => request('password')]
        {
            $objToken = $user->createToken('Nobis', ['user']);
            return response()->json(['token' => $objToken->accessToken, "user" => $user, "message" => "success"], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

}
