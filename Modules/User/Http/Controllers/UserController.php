<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\User\Http\Entities\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = auth('api')->login($user);

        return response()->json([
            'status' => 201,
            'message' => 'Registration successful',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status' => 401,
                'message' => 'Email or Password is invalid',
            ], 401);
        }

        $user = auth('api')->user();

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user,
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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()]);
        }

        $user->fill($request->only('name', 'email'));

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            if ($user->profile_image && file_exists(public_path('uploads/profile_images/' . $user->profile_image))) {
                unlink(public_path('uploads/profile_images/' . $user->profile_image));
            }

            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile_images'), $filename);

            $user->profile_image = $filename;
        }

        $user->save();

        return response()->json([
            'status'  => 200,
            'message' => 'User updated successfully',
            'user'    => new \Modules\User\Http\Transformers\UserResource($user)
        ]);
    }


    public function updateBanner(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => 401, 'message' => 'Unauthorized'], 401);
        }

        if (!$user->is_agency) {
            return response()->json(['status' => 403, 'message' => 'Only agents can update banner'], 403);
        }

        $validator = Validator::make($request->all(), [
            'background_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        if ($user->background_image && file_exists(public_path('uploads/banner_images/' . $user->background_image))) {
            unlink(public_path('uploads/banner_images/' . $user->background_image));
        }

        $file = $request->file('background_image');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/banner_images'), $filename);

        $user->background_image = $filename;
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Banner updated successfully',
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
