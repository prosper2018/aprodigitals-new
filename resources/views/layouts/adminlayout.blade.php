<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.partials.admin_head')
</head>

<body>

    <style>
        #login_days>label {
            margin-right: 50px;
        }
    </style>

    <div class="wrapper">
        @include('layouts.partials.sidebar')
        <div class="main">

            @include('layouts.partials.top_menubar')
            @yield('content')
            @include('layouts.partials.admin_footer')
        </div>
    </div>
    @include('layouts.partials.footer-scripts')
</body>

</html>