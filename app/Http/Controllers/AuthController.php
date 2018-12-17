<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('my-jwt', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $this->guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 4320
        ]);
    }

    public function guard() {
        return Auth::Guard('api');
    }

    //=======================    REGISTRATION NEW ACCAUNT FOR NEW USER ======================
    protected function validator(array $data)
    {
        $rules = [
            'name'      => 'required|min:3|max:29',
            'email'     => 'required|email|min:6|max:50|unique:users',
            'password'  => 'min:6|max:30|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation'  => 'required|min:6',
        ];
        return Validator::make($data, $rules);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'  => $data['name'],
            'email' => $data['email'],
            'password'  => bcrypt($data['password']),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->toArray()], Response::HTTP_BAD_REQUEST);
        }

        //Create user record
        $user = User::create([
            'name'             => $request->name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
        ]);

        if ($user)
        {
            $credentials = request(['email', 'password']);

            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Bad registration....'], 401);
            }

            return $this->respondWithToken($token);
        }
    }
}
