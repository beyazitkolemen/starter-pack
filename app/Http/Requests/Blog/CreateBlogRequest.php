<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gerekirse policy eklenebilir
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category_id' => 'required|integer|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'status' => 'nullable|string|in:draft,published,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Blog başlığı zorunludur.',
            'title.max' => 'Blog başlığı 255 karakterden uzun olamaz.',
            'content.required' => 'Blog içeriği zorunludur.',
            'content.min' => 'Blog içeriği en az 10 karakter olmalıdır.',
            'category_id.required' => 'Kategori seçimi zorunludur.',
            'category_id.exists' => 'Seçilen kategori bulunamadı.',
            'excerpt.max' => 'Özet 500 karakterden uzun olamaz.',
            'featured_image.max' => 'Öne çıkan resim URL\'si 255 karakterden uzun olamaz.',
            'tags.array' => 'Etiketler dizi formatında olmalıdır.',
            'tags.*.exists' => 'Seçilen etiket bulunamadı.',
            'status.in' => 'Geçersiz durum değeri.',
        ];
    }
}
