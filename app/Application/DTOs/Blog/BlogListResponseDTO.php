<?php

namespace App\Application\DTOs\Blog;

use App\Domain\Blog\Entities\Blog;

class BlogListResponseDTO
{
    public function __construct(
        public readonly array $blogs,
        public readonly array $pagination = []
    ) {}

    public function toArray(): array
    {
        return [
            'status' => 'success',
            'data' => [
                'blogs' => array_map(function(Blog $blog) {
                    $status = $blog->getStatus();

                    return [
                        'id' => $blog->getId(),
                        'title' => $blog->getTitle()->getValue(),
                        'slug' => $blog->getSlug()->getValue(),
                        'excerpt' => $blog->getExcerpt(),
                        'featured_image' => $blog->getFeaturedImage(),
                        'status' => [
                            'value' => $status->getValue(),
                            'label' => $status->getLabel(),
                            'color' => $status->getColor(),
                        ],
                        'author' => [
                            'id' => $blog->getAuthor()->getId(),
                            'name' => $blog->getAuthor()->getName()->getValue(),
                        ],
                        'category' => [
                            'id' => $blog->getCategory()->getId(),
                            'name' => $blog->getCategory()->getName()->getValue(),
                            'slug' => $blog->getCategory()->getSlug()->getValue(),
                        ],
                        'tags' => array_map(function($tag) {
                            return [
                                'id' => $tag->getId(),
                                'name' => $tag->getName()->getValue(),
                                'slug' => $tag->getSlug()->getValue(),
                            ];
                        }, $blog->getTags()),
                        'published_at' => $blog->getPublishedAt()?->format('Y-m-d H:i:s'),
                        'created_at' => $blog->getCreatedAt()->format('Y-m-d H:i:s'),
                        'view_count' => $blog->getViewCount(),
                        'is_featured' => $blog->isFeatured(),
                        'word_count' => $blog->getContent()->getWordCount(),
                    ];
                }, $this->blogs),
                'pagination' => $this->pagination,
            ]
        ];
    }
}
