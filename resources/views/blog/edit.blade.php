@extends('layouts.admin')
@section('content')
<div class="wrapper">
    @include('layouts.partials.sidebar')
    <div class="main">

        @include('layouts.partials.top_menubar')
        <div class="container" style="padding-top: 40px !important;">
            <div class="row justify-content-center">

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Post') }}</div>
                        @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                        @elseif(session()->has('error'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                        @endif
                        <form action="/blog/edit" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input name="post_id" id="post_id" type="hidden" value="{{ $post->id }}">
                                <div class="row mb-3">
                                    <label for="post_title" class="col-md-12 col-form-label">{{ __('Title') }}</label>

                                    <div class="col-md-12">
                                        <input id="post_title" type="text" class="form-control @error('post_title') is-invalid @enderror" name="post_title" value="{{ $post->title }}" required autocomplete="post_title" autofocus>

                                        @error('post_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="post_category_id" class="col-md-12 col-form-label">{{ __('Category') }}</label>

                                    <div class="col-md-12">
                                        <select class="form-control select  @error('post_category_id') is-invalid @enderror" name="post_category_id" id="post_category_id" style="width: 100% !important;">
                                            <option value="">::select option::</option>
                                            @foreach($categories as $key => $category)
                                            <option value="{{ $category->id }}" @if($post->post_category_id == $category->id) selected @endif>{{ $category->cat_title }}</option>
                                            @endforeach
                                        </select>
                                        @error('post_category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="post_author" class="col-md-12 col-form-label">{{ __('Author') }}</label>

                                    <div class="col-md-12">
                                        <input id="post_author" type="text" class="form-control @error('post_author') is-invalid @enderror" name="post_author" value="{{ $post->post_author }}" required autocomplete="post_author" autofocus>

                                        @error('post_author')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="post_status" class="col-md-12 col-form-label">{{ __('Status') }}</label>

                                    <div class="col-md-12">
                                        <select class="form-control select  @error('post_status') is-invalid @enderror" name="post_status" id="post_status" style="width: 100% !important;">
                                            <option value="">::select option::</option>
                                            <option value="published" @if($post->post_status == "published") selected @endif>Publish</option>
                                            <option value="draft" @if($post->post_status == "draft") selected @endif>Draft</option>
                                        </select>
                                        @error('post_status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="post_image" class="col-md-12 col-form-label">{{ __('Image') }}</label>

                                    <div class="col-md-6">
                                        <input id="post_image" type="file" class="form-control @error('post_image') is-invalid @enderror" name="post_image" value="{{ $post->post_image }}" autocomplete="post_image" autofocus>

                                        @error('post_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <img src="/images/{{ $post->post_image}}" width="50" height="50" alt="Post image">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="post_tags" class="col-md-12 col-form-label">{{ __('Tags') }}</label>

                                    <div class="col-md-12">
                                        <input id="post_tags" type="text" class="form-control @error('post_tags') is-invalid @enderror" name="post_tags" value="{{ $post->post_tags }}" required autocomplete="post_tags" autofocus>

                                        @error('post_tags')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="post_content_excerpt" class="col-md-12 col-form-label text-md-end">{{ __('Content Excerpt') }}</label>

                                    <div class="col-md-12">
                                        <textarea id="post_content_excerpt" type="text" class="form-control @error('post_content_excerpt') is-invalid @enderror" name="post_content_excerpt" value="{{ old('post_content_excerpt') }}" required autocomplete="post_content_excerpt" cols="30" rows="3">{{ $post->post_content_excerpt }}</textarea>

                                        @error('post_content_excerpt')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="page_1" class="col-md-12 col-form-label text-md-end">{{ __('Content - Page 1') }}</label>

                                    <div class="col-md-12">
                                        <textarea id="page_1" type="text" class="form-control @error('page_1') is-invalid @enderror" name="page_1" value="{{ old('page_1') }}" required autocomplete="page_1" cols="30" rows="3">{{ $post->page_1 }}</textarea>

                                        @error('page_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="page_2" class="col-md-12 col-form-label text-md-end">{{ __('Content - Page 2') }}</label>

                                    <div class="col-md-12">
                                        <textarea id="page_2" type="text" class="form-control @error('page_2') is-invalid @enderror" name="page_2" value="{{ old('page_2') }}" required autocomplete="page_1" cols="30" rows="5">{{ $post->page_1 }}</textarea>

                                        @error('page_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>
@endsection