<div>   
    <div class="d-flex py-3">
        <div class="flex-shrink-0 me-3">
            <div class="avatar-xs">
                <img src="{{ URL::asset($comment->users->avatar) }}" alt="User Avatar" class="img-fluid rounded-circle" />
            </div>
        </div>
        <div class="flex-grow-1">
            <h5 class="font-size-14 mb-1">{{ ucwords($comment->users->name) }} <small class="text-muted float-end">{{ $comment->created_at->diffForHumans() }}</small></h5>
            <p class="text-muted">{{ $comment->body }}</p>
            <div>
                <a href="javascript:void(0);" class="text-success" wire:click="showReplyBox({{ $comment->id }})"><i class="mdi mdi-reply"></i> Reply</a>
            </div>
            <div class="mt-2">
                <livewire:blog.like :data="$comment" :key="'comment-'.$comment->id" />

            </div>

            <!-- Reply box for the comment -->
            @if($replyToCommentId == $comment->id)
                <div class="reply-box mt-3 ms-5">
                    <textarea class="form-control mb-2" rows="2" placeholder="Write your reply..." wire:model="replyContent"></textarea>
                    <button class="btn btn-sm btn-primary" wire:click="submitReply({{ $comment->id }}, 'comment')">Submit</button>
                </div>
            @endif

            <!-- Display replies recursively -->
            @if($comment->replies)
                @foreach ($comment->replies as $reply)
                    <livewire:blog.comment :comment="$reply" :key="$reply->id" />
                @endforeach
            @endif
        </div>
        
    </div> 
</div>
