<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['body','user_id','commentable_id','commentable_type'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies() 
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
