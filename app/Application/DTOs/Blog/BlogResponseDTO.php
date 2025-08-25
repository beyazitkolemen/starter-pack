<?php

namespace App\Application\DTOs\Blog;

use App\Domain\Blog\Entities\Blog;

class BlogResponseDTO
{
    public function __construct(
        public readonly Blog $blog
    ) {}

    public function toArray(): array
    {
        $status = $this->blog->getStatus();
        
        return [
            'status' => 'success',
            'data' => [
                'blog' => [
                    'id' => $this->blog->getId(),
                    'title' => $this->blog->getTitle()->getValue(),
                    'content' => $this->blog->getContent()->getValue(),
                    'slug' => $this->blog->getSlug()->getValue(),
                    'status' => [
                        'value' => $status->getValue(),
                        'label' => $status->getLabel(),
                        'color' => $status->getColor(),
                        'icon' => $status->getIcon(),
                    ],
                    'excerpt' => $this->blog->getExcerpt(),
                    'featured_image' => $this->blog->getFeaturedImage(),
                    'author' => [
                        'id' => $this->blog->getAuthor()->getId(),
                        'name' => $this->blog->getAuthor()->getName()->getValue(),
                        'email' => $this->blog->getAuthor()->getEmail()->getValue(),
                    ],
                    'category' => [
                        'id' => $this->blog->getCategory()->getId(),
                        'name' => $this->blog->getCategory()->getName()->getValue(),
                        'slug' => $this->blog->getCategory()->getSlug()->getValue(),
                    ],
                    'tags' => array_map(function($tag) {
                        return [
                            'id' => $tag->getId(),
                            'name' => $tag->getName()->getValue(),
                            'slug' => $tag->getSlug()->getValue(),
                        ];
                    }, $this->blog->getTags()),
                    'published_at' => $this->blog->getPublishedAt()?->format('Y-m-d H:i:s'),
                    'created_at' => $this->blog->getCreatedAt()->format('Y-m-d H:i:s'),
                    'updated_at' => $this->blog->getUpdatedAt()->format('Y-m-d H:i:s'),
                    'view_count' => $this->blog->getViewCount(),
                    'is_featured' => $this->blog->isFeatured(),
                    'word_count' => $this->blog->getContent()->getWordCount(),
                ]
            ]
        ];
    }
}
