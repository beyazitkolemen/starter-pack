<?php

namespace App\Http\Requests\Blog;

use App\Domain\Blog\Enums\BlogStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gerekirse policy eklenebilir
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string|min:10',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'excerpt' => 'sometimes|nullable|string|max:500',
            'featured_image' => 'sometimes|nullable|string|max:255',
            'tags' => 'sometimes|nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'status' => [
                'sometimes',
                'string',
                Rule::in(BlogStatus::getAllValues())
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'Blog başlığı 255 karakterden uzun olamaz.',
            'content.min' => 'Blog içeriği en az 10 karakter olmalıdır.',
            'category_id.exists' => 'Seçilen kategori bulunamadı.',
            'excerpt.max' => 'Özet 500 karakterden uzun olamaz.',
            'featured_image.max' => 'Öne çıkan resim URL\'si 255 karakterden uzun olamaz.',
            'tags.array' => 'Etiketler dizi formatında olmalıdır.',
            'tags.*.exists' => 'Seçilen etiket bulunamadı.',
            'status.in' => 'Geçersiz durum değeri. Geçerli değerler: ' . implode(', ', BlogStatus::getAllValues()),
        ];
    }
}
