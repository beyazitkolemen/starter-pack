<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Domain\Blog\Services\BlogService;
use App\Domain\Blog\Exceptions\BlogNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteBlogController extends Controller
{
    public function __construct(
        private BlogService $blogService
    ) {}

    public function __invoke(Request $request, int $blogId): JsonResponse
    {
        try {
            $deleted = $this->blogService->deleteBlog($blogId);

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Blog başarıyla silindi'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Blog silinemedi'
            ], 500);
        } catch (BlogNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog bulunamadı'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog silinirken bir hata oluştu'
            ], 500);
        }
    }
}
