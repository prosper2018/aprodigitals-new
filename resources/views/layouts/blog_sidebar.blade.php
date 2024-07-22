<!-- User Login Form -->

{{-- <div class="well">
    <h4>Login</h4>
    <form action="includes/login.php" method="post">
        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username">
        </div>
        <div class="input-group">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span class="input-group-btn">
                <button type="submit" name="btn_login" class="btn btn-primary">Log In</button>
            </span>
        </div>
    </form>
    <h5 class="text-center"><a href="registration.php">Don't Have An Account ??</a></h5>
</div> --}}

<div class="sidebar">
    @if (auth()->check())
        <div class="card mb-4">
            <div class="card-header">{{ __('Menu') }}</div>
            <div class="card-body">
                <ul class="list-group">
                    <a href="/admin/blog" class="list-group-item list-group-action">View All</a>
                    <a href="{{ route('blog.create') }}" class="list-group-item list-group-action">Create</a>
                </ul>
            </div>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="card mb-4">
            <div class="card-body">
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <h3 class="sidebar-title">Content Search</h3>
    <div class="sidebar-item search-form">
        <form action="">
            <input type="text">
            <button type="button">
                <span class="bi bi-search"></span>
            </button>
        </form>
    </div><!-- End sidebar search formn-->

    <h3 class="sidebar-title">Categories</h3>
    <div class="sidebar-item categories">
        <ul>
            @foreach ($categories as $key => $category)
                <li><a href='{{ route('blog.category', $category->id) }}'>{{ $category->cat_title }}
                        <span>(25)</span></a></li>
            @endforeach
        </ul>
    </div><!-- End sidebar categories-->

    <h3 class="sidebar-title">Recent Posts</h3>
    <div class="sidebar-item recent-posts">
        @forelse($recent_blogs as $blogs)
            <div class="post-item clearfix">
                <img src="/images/{{ $blogs->post_image }}" alt="">
                <h4 class="post_views" data-id="{{ $blogs->id }}"><a href="/blog/{{ $blogs->id }}/page_1">{{ $blogs->title }}</a></h4>
                <time datetime="{{ $blogs->created_at }}">{{ date("F d, Y", strtotime($blogs->created_at)) }}</time>
            </div>
        @empty
            <p class="text-warning">No blog Posts available</p>
        @endforelse
    </div><!-- End sidebar recent posts-->

    <h3 class="sidebar-title">Tags</h3>
    <div class="sidebar-item tags">
        <ul>
            <li><a href="#">App</a></li>
            <li><a href="#">IT</a></li>
            <li><a href="#">Business</a></li>
            <li><a href="#">Mac</a></li>
            <li><a href="#">Design</a></li>
            <li><a href="#">Office</a></li>
            <li><a href="#">Creative</a></li>
            <li><a href="#">Studio</a></li>
            <li><a href="#">Smart</a></li>
            <li><a href="#">Tips</a></li>
            <li><a href="#">Marketing</a></li>
        </ul>
    </div><!-- End sidebar tags-->

</div><!-- End sidebar -->
