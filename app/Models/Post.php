<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'body', // Assuming this is the content of the post
        'excerpt',
        'category_id',
        'admin_id', // Assuming this is the ID of the admin user or author
        'status',
        'published_at',
        'meta_description',
        'meta_keywords',
        'featured_image', // For storing image paths,
        'is_trending',
        'is_featured',
        'is_top'
    ];
        public function categories(): BelongsTo 
    {
       return $this->belongsTo(Category::class,'category_id');
    }

    public function tags(): BelongsToMany
    {
       return $this->belongsToMany(Tag::class,'post_tag')->withTimestamps();
    }

    public function comments() 
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function likes() 
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function admins() 
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
}
