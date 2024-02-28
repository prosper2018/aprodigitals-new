<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="/assets/img/logo-removebg-preview.png" rel="icon">
  <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="/assets/css/google.fonts.css" rel="stylesheet">


  <!-- Vendor CSS Files -->
  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="/assets/select2/dist/css/select2.min.css" rel="stylesheet">

  <link rel="stylesheet" href="/assets/sweetalert2/dist/sweetalert2.min.css">

  <link href="/assets/DataTables/jquery.dataTables.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="/assets/DataTables/datatables.min.css" />
  <link rel="stylesheet" type="text/css" href="/assets/DataTables/responsive/css/responsive.bootstrap4.min.css" />

  <!-- Template Main CSS File -->
  <link href="/assets/css/style.css" rel="stylesheet">
  <!-- <link href="/assets/css/all.css" rel="stylesheet"> -->
  <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

  <style>
    .carousel-item {
      height: 100vh;
      min-height: 350px;
      background: no-repeat center center scroll;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }

    .navbar-dark .navbar-nav .active>.nav-link,
    .navbar-dark .navbar-nav .nav-link.active,
    .navbar-dark .navbar-nav .nav-link.show,
    .navbar-dark .navbar-nav .show>.nav-link {
      color: #007CC2;
    }

    .navbar-dark .navbar-nav .nav-link {
      display: block;
      position: relative;
      color: #000;
      transition: 0.3s;
      font-size: 15px;
      letter-spacing: 0.5px;
      font-weight: 500;
      font-family: "Open Sans", sans-serif;
      padding: 10px 0 10px 28px;
    }

    .navbar {
      padding: 15px 0;
      z-index: 997;
    }

    .navbar-dark .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(43,25,112, 1)' stroke-width='3' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
    }

    .custom-toggler.navbar-toggler {
      border-color: rgb(255, 102, 203);
    }

    .carousel-caption {
      color: white;
      background-color: rgba(0, 0, 0, 0.7);
      padding-top: 10px;
      padding-bottom: 100px;
      padding-left: 20px;
      padding-right: 20px;
    }

    @media only screen and (max-width: 768px) {

      /* For mobile phones: */
      .navbar-brand {
        margin-left: 10px;
      }

      .display-4 {
        font-size: 2.5rem;
        font-weight: 300;
        line-height: 1.2;
      }

      .navbar-toggler {
        margin-right: 10px;
      }
    }

    .carousel-caption {
      top: 45%;
      position: absolute;
      right: 15%;
      bottom: auto;
      left: 15%;
      z-index: 10;
      padding-top: 20px;
      padding-bottom: 20px;
      color: #fff;
      text-align: center;
    }
  </style>


  <!-- @livewireStyles -->
</head>