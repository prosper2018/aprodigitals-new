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
    
    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">

            <div class="row">

                <div class="col-lg-8 entries">
                    @if (!empty($count))
                        <h4>{{ $count }} contents found</h4>
                    @endif

                    @forelse($posts as $post)
                        <article class="entry">

                            <div class="entry-img post_views" data-id="{{ $post->id }}">
                                <img src="images/{{ $post->post_image }}" alt="" class="img-fluid">
                            </div>

                            <h2 class="entry-title post_views" data-id="{{ $post->id }}">
                                <a href="/blog/{{ $post->id }}/page_1">{{ $post->title }}</a>
                            </h2>

                            <div class="entry-meta  post_views" data-id="{{ $post->id }}  post_views">
                                <ul>
                                    <li class="d-flex align-items-center  post_views" data-id="{{ $post->id }}"><i class="bi bi-person"></i> <a
                                            href="/blog/{{ $post->id }}/page_1">{{ $post->post_author }}</a></li>
                                    <li class="d-flex align-items-center  post_views" data-id="{{ $post->id }}"><i class="bi bi-clock"></i> <a
                                            href="/blog/{{ $post->id }}/page_1"><time datetime="{{ $post->created_at }}">{{ date('F d, Y', strtotime($post->created_at)) }}</time></a></li>
                                    <li class="d-flex align-items-center  post_views" data-id="{{ $post->id }}"><i class="bi bi-eye"></i> <a
                                            href="/blog/{{ $post->id }}/page_1">{{ $post->post_views_count }} Views</a></li>
                                    <li class="d-flex align-items-center post_views" data-id="{{ $post->id }}"><i class="bi bi-chat-dots"></i> <a
                                            href="/blog/{{ $post->id }}/page_1">{{ $post->post_comment_count }} Comments</a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                <p class="post_views" data-id="{{ $post->id }}">
                                    {!! $post->post_content_excerpt !!}
                                </p>
                                <div class="read-more post_views" data-id="{{ $post->id }}">
                                    <a href="/blog/{{ $post->id }}/page_1">Read More</a>
                                </div>
                            </div>

                        </article><!-- End blog entry -->

                    @empty
                        <p class="text-warning">No blog Posts available</p>
                    @endforelse

                    <div class="blog-pagination">

                        {{ $posts->links('pagination::bootstrap-4') }}
                    </div>

                </div><!-- End blog entries list -->

                <div class="col-lg-4">
                    @include('layouts.blog_sidebar')
                </div><!-- End blog sidebar -->

            </div>

        </div>
    </section><!-- End Blog Section -->
@endsection
