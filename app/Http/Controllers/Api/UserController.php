<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong... Please try again!!',
                'status_code' => Response::HTTP_REQUEST_TIMEOUT,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Registration Successfull!!',
                'status_code' => Response::HTTP_OK,
                'data' => $user,
                'access_token' => $user->createToken('personal_token')->plainTextToken
            ]);
        }
    }

    public function login(Request $request)
    {
        if (!($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => "Credentials don't exist!!!",
                'status_code' => Response::HTTP_REQUEST_TIMEOUT,
            ]);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        return response()->json([
            'success' => true,
            'message' => 'Login Successfull!',
            'status_code' => Response::HTTP_OK,
            'data' => $user,
            'access_token' => $user->createToken('personal_token')->plainTextToken

        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user()->tokens()->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Sign out successful!!",
                'status_code' => Response::HTTP_OK
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "An error occurred. Unable to logout!!",
                'status_code' => Response::HTTP_METHOD_NOT_ALLOWED
            ]);
        }
    }
}
