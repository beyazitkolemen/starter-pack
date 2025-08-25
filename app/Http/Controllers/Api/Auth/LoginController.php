<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Domain\Auth\Services\AuthService;
use App\Application\DTOs\Auth\LoginResponseDTO;
use App\Domain\Auth\Exceptions\InvalidCredentialsException;
use App\Domain\Auth\Exceptions\UserNotFoundException;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $result = $this->authService->login(
                $validated['email'],
                $validated['password']
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
}
