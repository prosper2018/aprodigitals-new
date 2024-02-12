@extends('layouts.layout')
@section('content')
<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs breadcrumbs-label">
    <div class="container">

        <ol>
            <li><a href="/" class="breadcrumbs-link">Home</a></li>
            <li>Blog</li>
        </ol>
        <h2 style="color: white;">Blog</h2>

    </div>
</section><!-- End Breadcrumbs -->
<div class="container" style="padding-top: 40px !important;">

    <div class="row">
        <div class="card col-lg-8 py-3">
            <div class="card-body">
                <div class="col-12 pt-2">
                    <div class="row">
                        <div class="col-8">
                            <h1 class="display-one">Our Blog!</h1>
                            <p>Enjoy reading our posts. Click on a post to read!</p>
                        </div>
                        <div class="col-4">
                            <p>Create new Post</p>
                            <a href="/blog/create/post" class="btn btn-primary btn-sm">Add Post</a>
                        </div>
                    </div>
                    @if(!empty($count))
                    <h4>{{ $count }} contents found</h4>
                    @endif<hr>
                    @forelse($posts as $post)
                    <h2 class="post_views" data-id="{{ $post->id }}"><a href="/blog/{{ $post->id }}/page_1">{{ $post->title }}</a></h2>
                    <p class="lead post_views" data-id="{{ $post->id }}">
                        By <a href="javascript:void()">{{ $post->post_author }}</a>
                    </p>
                    <p class="post_views" data-id="{{ $post->id }}"><span class="glyphicon glyphicon-time"></span> Posted on {{ date("d F Y", strtotime($post->created_at)) }} at {{ date("h:i:sa", strtotime($post->created_at)) }} &nbsp; <i class="icofont-comment" style="font-size: 20px;color:#007CC2;">{{ " ".$post->post_comment_count }}</i> <i class="icofont-eye" style="font-size: 20px;color:#007CC2;">{{ " ".$post->post_views_count }}</i></p>
                    <img class="img-responsive" src="images/{{ $post->post_image }}"><br>
                    <p class="post_views" data-id="{{ $post->id }}">
                        {!! $post->post_content_excerpt !!} <span>
                        <a href="/blog/{{ $post->id }}/page_1"><strong>Read More</strong></a></span>
                    </p>
                    <hr>

                    @empty
                    <p class="text-warning">No blog Posts available</p>
                    @endforelse
                    <p class="pagination text-end">{{ $posts->links('pagination::bootstrap-4') }}</p>
                </div>

            </div>

        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">{{ __('Menu') }}</div>
                <div class="card-body">
                    <ul class="list-group">
                        <a href="/admin/blog" class="list-group-item list-group-action">View All</a>
                        <a href="{{ route('blog.create') }}" class="list-group-item list-group-action">Create</a>
                    </ul>
                </div>
            </div>
            @if (count($errors)>0)
            <div class="card mt-5">
                <div class="card-body">
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @include("layouts.blog_sidebar")
        </div>

    </div>
</div>
@endsection