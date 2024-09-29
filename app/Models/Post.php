<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

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

    public function users() 
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
