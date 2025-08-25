<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Domain\Blog\Services\BlogService;
use App\Application\DTOs\Blog\BlogResponseDTO;
use App\Domain\Blog\Exceptions\BlogNotFoundException;
use App\Domain\Blog\Exceptions\CategoryNotFoundException;
use App\Domain\Blog\Exceptions\TagNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateBlogController extends Controller
{
    public function __construct(
        private BlogService $blogService
    ) {}

    public function __invoke(UpdateBlogRequest $request, int $blogId): JsonResponse
    {
        try {
            $validated = $request->validated();

            $blog = $this->blogService->updateBlog($blogId, $validated);
            $responseDTO = new BlogResponseDTO($blog);

            return response()->json($responseDTO->toArray());
        } catch (BlogNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog bulunamadı'
            ], 404);
        } catch (CategoryNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        } catch (TagNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog güncellenirken bir hata oluştu'
            ], 500);
        }
    }
}
