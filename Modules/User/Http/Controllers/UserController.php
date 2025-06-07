<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\User\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\User\Http\Entities\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->safe();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => 201,
            'message' => 'Registration successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['status' => 401, 'message' => 'Invalid credentials']);
        }

        $user = auth()->user();

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => 401, 'message' => 'Unauthorized']);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()]);
        }

        $user->fill($request->only('name', 'email'));

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'User updated',
            'user' => $user
        ]);
    }

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()]);
        }

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => hash('sha256', $token), 'created_at' => now()]
        );

        Mail::raw("Your password reset token: $token", function ($message) use ($request) {
            $message->to($request->email)->subject("Password Reset");
        });

        return response()->json([
            'status' => 200,
            'message' => 'Reset link sent'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|exists:users,email',
            'token'    => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()]);
        }

        $record = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$record || !hash_equals($record->token, hash('sha256', $request->token))) {
            return response()->json(['status' => 400, 'message' => 'Invalid token']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Password reset successful'
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logged out']);
    }
}
