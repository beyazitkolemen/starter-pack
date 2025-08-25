<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CreateBlogRequest;
use App\Domain\Blog\Services\BlogService;
use App\Application\DTOs\Blog\BlogResponseDTO;
use Illuminate\Http\JsonResponse;

class CreateBlogController extends Controller
{
    public function __construct(
        private BlogService $blogService
    ) {}

    public function __invoke(CreateBlogRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $blog = $this->blogService->createBlog($validated, $request->user());

            $responseDTO = new BlogResponseDTO($blog);

            return response()->json($responseDTO->toArray(), 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog oluşturulurken bir hata oluştu'
            ], 500);
        }
    }
}
