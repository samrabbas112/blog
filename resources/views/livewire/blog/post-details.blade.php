<div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="pt-3">
                    <div class="row justify-content-center">
                        <div class="col-xl-8">
                            <div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <a href="#" class="badge bg-light font-size-12">
                                            <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> {{ $post->categories->name}}
                                        </a>
                                    </div>
                                    <h4>{{ $post->title }}</h4>
                                    <p class="text-muted mb-4"><i class="mdi mdi-calendar me-1"></i> {{ date('d M, Y',strtotime($post->created_at)) }}</p>
                                </div>

                                <hr>
                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div>
                                                <p class="text-muted mb-2">Categories</p>
                                                <h5 class="font-size-15">{{ $post->categories->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Date</p>
                                                <h5 class="font-size-15">{{ date('d M, Y',strtotime($post->created_at)) }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <p class="text-muted mb-2">Post by</p>
                                                <h5 class="font-size-15">{{ $post->admins->name }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="my-5">
                                    <?php 
                                    $image = json_decode($post->featured_image,true);
                                    ?>
                                    <img src="{{ URL::asset('storage/' . (isset($image[0]) ? $image[0] : 'posts/NoImage.jpg')) }}" alt="" class="img-thumbnail mx-auto d-block">
                                </div>

                                <hr>

                                <div class="mt-4">
                                    <div class="text-muted font-size-14 ">
                                        <p>{!! $post->body !!}</p>
                                    </div>
                                    
                                    <livewire:blog.like :data="$post" :key="'post-'.$post->id" />

                                    {{-- <div class="mt-2">
                                        <a href="javascript:void(0);" wire:click="likePost({{ $post->id }})" class="like-button">
                                            <i class="mdi mdi-thumb-up {{ $post->likes()->where('user_id', auth()->id())->exists() ? 'text-primary' : 'text-muted' }}"></i> 
                                            <span class="like-count">{{ $this->likesCount }} Like{{ $this->likesCount === 1 ? '' : 's' }}</span>
                                        </a>
                                    </div> --}}
                            
                                    <hr>
                                    
                                    <div id="comments-section">
        
                                        <div class="mt-5">
                                            <h5 class="font-size-15">
                                                <i class="bx bx-message-dots text-muted align-middle me-1"></i> Comments :
                                            </h5>
                                            @if($post->comments->isEmpty())
                                                        <!-- No comments message -->
                                            <div id="no-comments-message">
                                                <p class="text-muted">No comments yet. Be the first to comment!</p>
                                            </div>
                                            
                                             <!-- Comment input box -->
                                             
                                            @else
                                            @foreach ($post->comments as $comment)
                                            <livewire:blog.comment :comment="$comment" :post="$post" :key="$comment->id" />
                                            @endforeach
                                            @endif
                                            <div class="mt-4">
                                                <textarea class="form-control mb-2" wire:model="replyContent" rows="3" placeholder="Enter your comment..."></textarea>
                                                <button class="btn btn-primary" wire:click="submitReply">Submit Comment</button>
                                            </div>       
                                        </div>
                                    </div>
                                   
                                
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>

</div>
