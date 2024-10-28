@extends('layouts.master-layouts')

@section('title') @lang('translation.Post_Details') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Post @endslot
@slot('title') Post Details @endslot
@endcomponent

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
                                    <div class="text-muted font-size-14">
                                        <p>{!! $post->body !!}</p>
                                    </div>

                                    <hr>
                                    @if($post->comments->isEmpty())
                                    <livewire:blog.comment :comment="null" :post="$post" :key="uniqid()" />
                                    @else
                                    @foreach ($post->comments as $comment)
                                    <livewire:blog.comment :comment="$comment" :post="$post" :key="$comment->id" />
                                    @endforeach
                                    @endif
                                
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
<!-- end row -->

@endsection