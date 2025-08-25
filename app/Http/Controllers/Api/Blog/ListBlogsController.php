<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Domain\Blog\Services\BlogService;
use App\Application\DTOs\Blog\BlogListResponseDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListBlogsController extends Controller
{
    public function __construct(
        private BlogService $blogService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $page = (int) $request->get('page', 1);
            $perPage = (int) $request->get('per_page', 10);
            $status = $request->get('status');
            $categoryId = $request->get('category_id');
            $tagId = $request->get('tag_id');
            $search = $request->get('search');
            $featured = $request->get('featured');
            $popular = $request->get('popular');

            $blogs = [];

            if ($search) {
                $blogs = $this->blogService->searchBlogs($search, $page, $perPage);
            } elseif ($categoryId) {
                $blogs = $this->blogService->getBlogsByCategory($categoryId, $page, $perPage);
            } elseif ($tagId) {
                $blogs = $this->blogService->getBlogsByTag($tagId, $page, $perPage);
            } elseif ($featured) {
                $blogs = $this->blogService->getFeaturedBlogs($perPage);
            } elseif ($popular) {
                $blogs = $this->blogService->getPopularBlogs($perPage);
            } else {
                $blogs = $this->blogService->getPublishedBlogs($page, $perPage);
            }

            $pagination = [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => count($blogs),
            ];

            $responseDTO = new BlogListResponseDTO($blogs, $pagination);

            return response()->json($responseDTO->toArray());
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Blog\'lar listelenirken bir hata oluştu'
            ], 500);
        }
    }
}
