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
        <div class="col-lg-8 pt-2">

            <h3>{{ $post->title }}</h3>
            <i class="icofont-comment col-sm-1" style="font-size: 20px;color:#007CC2;"> {{ $post->post_comment_count }}</i>
            <i class="icofont-eye" style="font-size: 20px;color:#007CC2;"> {{ " " . $post->post_views_count }}</i>
            <hr>
            <video width='700' height='250' controls>
                <source src='videos/{{ $post->post_video }}' type='video/mp4'>Your browser does not support the video tag. Upgrade your browser.
            </video>

            <div class="py-4">
                {!! $page !!}
            </div>

            <ul class="pager">
                @for ($i = 1; $i <= 2; $i++) @if ($i==$page_id) <li><a class='active_link' href='/blog/{{ $post->id }}/page_{{$i}}'>{{$i}}</a></li>
                    @else <li><a href='/blog/{{ $post->id }}/page_{{$i}}'>{{$i}}</a></li>
                    @endif
                    @endfor
            </ul>
            <hr>
            <!-- Leave Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @elseif(session()->has('error'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="comment_post_id" value="{{ $post->id }}">
                    <div class="form-group">
                        <label for="comment_author">Name</label>
                        <input type="text" class="form-control" name="comment_author" required>
                        @error('comment_author')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="comment_email">Email</label>
                        <input type="email" class="form-control" name="comment_email" required>
                        @error('comment_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="comment_content">Comment</label>
                        <textarea class="form-control" name="comment_content" rows="3" required></textarea>
                        @error('comment_content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" name="btn_comment" class="btn btn-primary">Comment</button>
                </form>


            </div><br>

        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">{{ __('Menu') }}</div>
                <div class="card-body">
                    <ul class="list-group">
                        <a href="/admin/blog" class="list-group-item list-group-action">View All</a>
                        <a href="{{ route('blog.create') }}" class="list-group-item list-group-action">Create</a>
                    </ul>
                </div>
            </div>
            @include("layouts.blog_sidebar")
        </div>
    </div>
</div>
@endsection