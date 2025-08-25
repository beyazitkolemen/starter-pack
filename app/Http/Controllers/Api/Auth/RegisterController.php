<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Domain\Auth\Services\AuthService;
use App\Application\DTOs\Auth\RegisterResponseDTO;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $result = $this->authService->register(
                $validated['name'],
                $validated['email'],
                $validated['password']
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
}
