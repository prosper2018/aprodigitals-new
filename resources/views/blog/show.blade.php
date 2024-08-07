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
    {{-- <div class="container" style="padding-top: 40px !important;">
        <div class="row">
            <div class="col-lg-8 pt-2">

                <h3>{{ $post->title }}</h3>
                <i class="icofont-comment col-sm-1" style="font-size: 20px;color:#007CC2;">
                    {{ $post->post_comment_count }}</i>
                <i class="icofont-eye" style="font-size: 20px;color:#007CC2;"> {{ ' ' . $post->post_views_count }}</i>
                <hr>
                <video width='700' height='250' controls>
                    <source src='videos/{{ $post->post_video }}' type='video/mp4'>Your browser does not support the video
                    tag. Upgrade your browser.
                </video>

                <div class="py-4">
                    {!! $page !!}
                </div>

                <ul class="pager">
                    @for ($i = 1; $i <= 2; $i++)
                        @if ($i == $page_id)
                            <li><a class='active_link'
                                    href='/blog/{{ $post->id }}/page_{{ $i }}'>{{ $i }}</a></li>
                        @else
                            <li><a href='/blog/{{ $post->id }}/page_{{ $i }}'>{{ $i }}</a></li>
                        @endif
                    @endfor
                </ul>
                <hr>
                <!-- Leave Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>


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

        </div>
    </div> --}}

    <!-- ======= Blog Single Section ======= -->
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">

            <div class="row">

                <div class="col-lg-8 entries">

                    <article class="entry entry-single">

                        <div class="entry-img">
                            <img src="/images/{{ $post->post_image }}" alt="" class="img-fluid">
                        </div>

                        <h2 class="entry-title">
                            <a href="/blog/{{ $post->id }}/page_1">{{ $post->title }}</a>
                        </h2>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center  post_views" data-id="{{ $post->id }}"><i
                                        class="bi bi-person"></i> <a
                                        href="/blog/{{ $post->id }}/page_1">{{ $post->post_author }}</a></li>
                                <li class="d-flex align-items-center  post_views" data-id="{{ $post->id }}"><i
                                        class="bi bi-clock"></i> <a href="/blog/{{ $post->id }}/page_1"><time
                                            datetime="{{ $post->created_at }}">{{ date('F d, Y', strtotime($post->created_at)) }}</time></a>
                                </li>
                                <li class="d-flex align-items-center  post_views" data-id="{{ $post->id }}"><i
                                        class="bi bi-eye"></i> <a
                                        href="/blog/{{ $post->id }}/page_1">{{ $post->post_views_count }} Views</a>
                                </li>
                                <li class="d-flex align-items-center post_views" data-id="{{ $post->id }}"><i
                                        class="bi bi-chat-dots"></i> <a
                                        href="/blog/{{ $post->id }}/page_1">{{ $post->post_comment_count }}
                                        Comments</a></li>
                            </ul>
                        </div>

                        <div class="entry-content">
                            <p>
                                {!! $post->page_1 !!}
                            </p>

                            <blockquote>
                                <p>
                                    {!! $post->post_content_excerpt !!}
                                </p>
                            </blockquote>

                            <p>
                                {!! $post->page_2 !!}
                            </p>

                        </div>

                        <div class="entry-footer">
                            <i class="bi bi-folder"></i>
                            <ul class="cats">
                                <li><a href="#">Business</a></li>
                            </ul>

                            <i class="bi bi-tags"></i>
                            <ul class="tags">
                                @for ($i = 0; $i < count($tags); $i++)
                                    <li><a href="#">{{ $tags[$i] }}</a></li>
                                @endfor
                            </ul>
                        </div>

                    </article><!-- End blog entry -->

                    {{-- <div class="blog-author d-flex align-items-center">
                        <img src="assets/img/blog/blog-author.jpg" class="rounded-circle float-left" alt="">
                        <div>
                            <h4>Jane Smith</h4>
                            <div class="social-links">
                                <a href="https://twitters.com/#"><i class="bi bi-twitter"></i></a>
                                <a href="https://facebook.com/#"><i class="bi bi-facebook"></i></a>
                                <a href="https://instagram.com/#"><i class="biu bi-instagram"></i></a>
                            </div>
                            <p>
                                Itaque quidem optio quia voluptatibus dolorem dolor. Modi eum sed possimus accusantium. Quas
                                repellat voluptatem officia numquam sint aspernatur voluptas. Esse et accusantium ut unde
                                voluptas.
                            </p>
                        </div>
                    </div><!-- End blog author bio --> --}}

                    <div class="blog-comments">

                        <h4 class="comments-count">8 Comments</h4>

                        <div id="comment-1" class="comment">
                            <div class="d-flex">
                                <div class="comment-img"><img src="assets/img/blog/comments-1.jpg" alt=""></div>
                                <div>
                                    <h5><a href="">Georgia Reader</a> <a href="#" class="reply"><i
                                                class="bi bi-reply-fill"></i> Reply</a></h5>
                                    <time datetime="2020-01-01">01 Jan, 2020</time>
                                    <p>
                                        Et rerum totam nisi. Molestiae vel quam dolorum vel voluptatem et et. Est ad aut
                                        sapiente quis molestiae est qui cum soluta.
                                        Vero aut rerum vel. Rerum quos laboriosam placeat ex qui. Sint qui facilis et.
                                    </p>
                                </div>
                            </div>
                        </div><!-- End comment #1 -->

                        <div id="comment-2" class="comment">
                            <div class="d-flex">
                                <div class="comment-img"><img src="assets/img/blog/comments-2.jpg" alt=""></div>
                                <div>
                                    <h5><a href="">Aron Alvarado</a> <a href="#" class="reply"><i
                                                class="bi bi-reply-fill"></i> Reply</a></h5>
                                    <time datetime="2020-01-01">01 Jan, 2020</time>
                                    <p>
                                        Ipsam tempora sequi voluptatem quis sapiente non. Autem itaque eveniet saepe.
                                        Officiis illo ut beatae.
                                    </p>
                                </div>
                            </div>

                            <div id="comment-reply-1" class="comment comment-reply">
                                <div class="d-flex">
                                    <div class="comment-img"><img src="assets/img/blog/comments-3.jpg" alt="">
                                    </div>
                                    <div>
                                        <h5><a href="">Lynda Small</a> <a href="#" class="reply"><i
                                                    class="bi bi-reply-fill"></i> Reply</a></h5>
                                        <time datetime="2020-01-01">01 Jan, 2020</time>
                                        <p>
                                            Enim ipsa eum fugiat fuga repellat. Commodi quo quo dicta. Est ullam aspernatur
                                            ut vitae quia mollitia id non. Qui ad quas nostrum rerum sed necessitatibus aut
                                            est. Eum officiis sed repellat maxime vero nisi natus. Amet nesciunt nesciunt
                                            qui illum omnis est et dolor recusandae.

                                            Recusandae sit ad aut impedit et. Ipsa labore dolor impedit et natus in porro
                                            aut. Magnam qui cum. Illo similique occaecati nihil modi eligendi. Pariatur
                                            distinctio labore omnis incidunt et illum. Expedita et dignissimos distinctio
                                            laborum minima fugiat.

                                            Libero corporis qui. Nam illo odio beatae enim ducimus. Harum reiciendis error
                                            dolorum non autem quisquam vero rerum neque.
                                        </p>
                                    </div>
                                </div>

                                <div id="comment-reply-2" class="comment comment-reply">
                                    <div class="d-flex">
                                        <div class="comment-img"><img src="assets/img/blog/comments-4.jpg"
                                                alt=""></div>
                                        <div>
                                            <h5><a href="">Sianna Ramsay</a> <a href="#" class="reply"><i
                                                        class="bi bi-reply-fill"></i> Reply</a></h5>
                                            <time datetime="2020-01-01">01 Jan, 2020</time>
                                            <p>
                                                Et dignissimos impedit nulla et quo distinctio ex nemo. Omnis quia dolores
                                                cupiditate et. Ut unde qui eligendi sapiente omnis ullam. Placeat porro est
                                                commodi est officiis voluptas repellat quisquam possimus. Perferendis id
                                                consectetur necessitatibus.
                                            </p>
                                        </div>
                                    </div>

                                </div><!-- End comment reply #2-->

                            </div><!-- End comment reply #1-->

                        </div><!-- End comment #2-->

                        <div id="comment-3" class="comment">
                            <div class="d-flex">
                                <div class="comment-img"><img src="assets/img/blog/comments-5.jpg" alt=""></div>
                                <div>
                                    <h5><a href="">Nolan Davidson</a> <a href="#" class="reply"><i
                                                class="bi bi-reply-fill"></i> Reply</a></h5>
                                    <time datetime="2020-01-01">01 Jan, 2020</time>
                                    <p>
                                        Distinctio nesciunt rerum reprehenderit sed. Iste omnis eius repellendus quia nihil
                                        ut accusantium tempore. Nesciunt expedita id dolor exercitationem aspernatur aut
                                        quam ut. Voluptatem est accusamus iste at.
                                        Non aut et et esse qui sit modi neque. Exercitationem et eos aspernatur. Ea est
                                        consequuntur officia beatae ea aut eos soluta. Non qui dolorum voluptatibus et optio
                                        veniam. Quam officia sit nostrum dolorem.
                                    </p>
                                </div>
                            </div>

                        </div><!-- End comment #3 -->

                        <div id="comment-4" class="comment">
                            <div class="d-flex">
                                <div class="comment-img"><img src="assets/img/blog/comments-6.jpg" alt=""></div>
                                <div>
                                    <h5><a href="">Kay Duggan</a> <a href="#" class="reply"><i
                                                class="bi bi-reply-fill"></i> Reply</a></h5>
                                    <time datetime="2020-01-01">01 Jan, 2020</time>
                                    <p>
                                        Dolorem atque aut. Omnis doloremque blanditiis quia eum porro quis ut velit tempore.
                                        Cumque sed quia ut maxime. Est ad aut cum. Ut exercitationem non in fugiat.
                                    </p>
                                </div>
                            </div>

                        </div><!-- End comment #4 -->

                        <div class="reply-form">
                            <h4>Leave a Reply</h4>
                            <p>Your email address will not be published. Required fields are marked * </p>
                            @if (session()->has('message'))
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
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <input name="comment_author" type="text" class="form-control"
                                            placeholder="Your Name*">
                                        @error('comment_author')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input name="comment_email" type="text" class="form-control"
                                            placeholder="Your Email*">
                                        @error('comment_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col form-group">
                                        <textarea name="comment_content" class="form-control" placeholder="Your Comment*"></textarea>
                                        @error('comment_content')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" name="btn_comment" class="btn btn-primary">Post Comment</button>

                            </form>

                        </div>

                    </div><!-- End blog comments -->

                </div><!-- End blog entries list -->

                <div class="col-lg-4">
                    @include('layouts.blog_sidebar')
                </div><!-- End blog sidebar -->

            </div>

        </div>
    </section><!-- End Blog Single Section -->
@endsection
