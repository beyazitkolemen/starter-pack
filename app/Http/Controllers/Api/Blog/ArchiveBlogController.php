<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Domain\Blog\Services\BlogService;
use App\Application\DTOs\Blog\BlogResponseDTO;
use App\Domain\Blog\Exceptions\BlogNotFoundException;
use App\Domain\Blog\Exceptions\InvalidBlogStatusException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArchiveBlogController extends Controller
{
    public function __construct(
        private BlogService $blogService
    ) {}

    public function __invoke(Request $request, int $blogId): JsonResponse
    {
        try {
            $blog = $this->blogService->archiveBlog($blogId);
            $responseDTO = new BlogResponseDTO($blog);

            return response()->json([
                'status' => 'success',
                'message' => 'Blog başarıyla arşivlendi',
                'data' => $responseDTO->toArray()['data']
            ]);
        } catch (BlogNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog bulunamadı'
            ], 404);
        } catch (InvalidBlogStatusException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog arşivlenirken bir hata oluştu'
            ], 500);
        }
    }
}
