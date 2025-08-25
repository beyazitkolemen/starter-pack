<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Domain\Auth\Services\AuthService;
use App\Application\DTOs\Auth\LoginResponseDTO;
use App\Application\DTOs\Auth\RegisterResponseDTO;
use App\Application\DTOs\Auth\UserResponseDTO;
use App\Domain\Auth\Exceptions\InvalidCredentialsException;
use App\Domain\Auth\Exceptions\UserNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->register(
                $request->name,
                $request->email,
                $request->password
            );

            $responseDTO = new RegisterResponseDTO($result['user'], $result['token']);

            return response()->json($responseDTO->toArray(), 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bir hata oluştu'
            ], 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login(
                $request->email,
                $request->password
            );

            $responseDTO = new LoginResponseDTO($result['user'], $result['token']);

            return response()->json($responseDTO->toArray());
        } catch (InvalidCredentialsException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 401);
        } catch (UserNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bir hata oluştu'
            ], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user()->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Çıkış yapıldı'
            ]);
        } catch (UserNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bir hata oluştu'
            ], 500);
        }
    }

    public function user(Request $request): JsonResponse
    {
        try {
            $user = $this->authService->getCurrentUser($request->user()->id);

            $responseDTO = new UserResponseDTO($user);

            return response()->json($responseDTO->toArray());
        } catch (UserNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bir hata oluştu'
            ], 500);
        }
    }
}
