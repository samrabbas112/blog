<?php

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('like-channel.post.{post}', function ($user, Post $post) {
    return true; // Optional: Implement your custom authorization logic here
});

Broadcast::channel('like-channel.comment.{comment}', function ($user, Comment $comment) {
    return true; // Optional: Implement your custom authorization logic here
});

Broadcast::channel('comment-channel.{comment}', function ($user, Comment $comment) {
    return true; // Optional: Implement your custom authorization logic here
});

