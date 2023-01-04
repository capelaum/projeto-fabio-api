<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getAuthUser(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Register new User.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        event(new Registered($user));

        return response()->json([
            'user' => new UserResource($user),
        ], 201);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->ensureIsNotRateLimited();

        if (Auth::attempt($request->validated())) {
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();

                return response()->json([
                    'message' => 'Verifique seu e-mail para fazer login. Um novo e-mail de verificação foi enviado para' . $user->email
                ], 401);
            }

            $userToken = $user->createToken('auth', ['user'])->plainTextToken;

            RateLimiter::clear($request->throttleKey());

            return response()->json([
                'message' => "Bem vindo(a) {$user->name}",
                'token' => $userToken,
                'user' => new UserResource($user),
            ], 200);
        }

        RateLimiter::hit($request->throttleKey());

        return response()->json([
            'message' => 'Credenciais inválidas',
        ], 401);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!'
        ], 200);
    }
}
