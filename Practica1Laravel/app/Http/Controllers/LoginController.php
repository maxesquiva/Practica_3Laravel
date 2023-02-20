<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\checkUserIsLogged;
use App\Models\User;
use Illuminate\Http\Response;
use Throwable;

class LoginController extends Controller
{

    // public function login(Request $request)
    // {
    //     $data = $request->validate([
    //         'email' => 'required|email:rfc',
    //         'password' => 'required',
    //     ]);

    //     if(!auth()->attempt($data)) {
    //         abort(Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
    //     }

    //     $user = Auth::user();
    //     $accessToken = $user->createToken('auth_token');

    //     return response()->json(['user' => Auth::user(), 'token' => $accessToken]);

    // }


    // public function me(Request $request)
    // {
    //     return auth('api')->user();
    // }

    // public function logout(Request $request) {
    //     auth('api')->user()->currentAccessToken()->delete();

    //     $response = [
    //         'success' => true,
    //         'message' => 'ha cerrado sesion',
    //         'data' => ''
    //     ];
    //     return response()->json($response);
    // }


    public function login(Request $request)
    {

        if($request ->has ('name')){
            $data = $request->validate([
                            'name' => 'required',
                            'password' => 'required'
                        ]);
        }
        // switch ($request) {
        //     case ($request->has('name')):
        //         $data = $request->validate([
        //             'name' => 'required',
        //             'password' => 'required'
        //         ]);
        //         break;
        //     case ($request->has('email')):
        //         $data = $request->validate([
        //             'email' => 'required',
        //             'password' => 'required'
        //         ]);
        //         break;
        // }
        //guarda el token
        if (Auth::guard(name: 'api')->check()) {
            $response = [
                'success' => true,
                'message' => 'Login successful',
                'data' => $data
            ];
            return response()->json($response);
            // Auth:attempt valida los datos en la bd
        } else if (Auth::attempt($data)) {
            return Auth::user()->createToken("token");
        }

        return 'Unauthenticated';
    }

    public function me(Request $request)
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function logout(Request $request)
    {
        Auth::guard(name: 'api')->user()->tokens()->delete();

        $response = [
            'success' => true,
            'message' => 'Logout Success',
            'data' => ''
        ];
        return response()->json($response);
    }

    public function create(Request $request)
        {
            $id = null;
            try {
                $id = User::insertGetId($request->validate([
                    'name' => 'required|string',
                    'email' => 'required|string|unique:users',
                    'password' => 'required|string',
                ]));
            } catch (Throwable $e) {
                report($e);

                $response = [
                    'success' => false,
                    'message' => 'User has not been created, some data may be missing',
                    'data' => null
                ];
                return response()->json($response, 422);
            }
            if (is_numeric($id)) {
                $response = [
                    'success' => true,
                    'message' => 'User created successfully',
                    'data' => User::findOrFail($id)
                ];
                return response()->json($response, 200);
            }
        }
    }
// post usser controller que cre usuario
// metodo post copiar y cambiar
