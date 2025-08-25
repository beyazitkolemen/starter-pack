<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Domain\Blog\Services\BlogService;
use App\Application\DTOs\Blog\BlogResponseDTO;
use App\Domain\Blog\Exceptions\BlogNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetBlogController extends Controller
{
    public function __construct(
        private BlogService $blogService
    ) {}

    public function __invoke(Request $request, string $slug): JsonResponse
    {
        try {
            $blog = $this->blogService->getBlogBySlug($slug);
            $responseDTO = new BlogResponseDTO($blog);

            return response()->json($responseDTO->toArray());
        } catch (BlogNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog bulunamadı'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog getirilirken bir hata oluştu'
            ], 500);
        }
    }
}
