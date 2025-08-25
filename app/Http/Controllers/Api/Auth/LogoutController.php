<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Domain\Auth\Services\AuthService;
use App\Domain\Auth\Exceptions\UserNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function __invoke(Request $request): JsonResponse
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
}
