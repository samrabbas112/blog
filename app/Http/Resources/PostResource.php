<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'excerpt' => $this->excerpt,
            'featured_image' => $this->featured_image,
            'category' => new CategoryResource($this->categories),
            'tags' => new TagResource($this->tags),
            'admin_id' => $this->admin_id,
            'status' => $this->status,
            'is_trending' => $this->is_trending,
            'is_featured' => $this->is_featured,
            'is_top' => $this->is_top,
            'published_at' => $this->published_at,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'likes_count' => $this->likes_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
