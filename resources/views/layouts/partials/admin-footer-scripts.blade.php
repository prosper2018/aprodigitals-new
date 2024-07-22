<a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
<div id="preloader"></div>


<!-- Vendor JS Files -->
<script src="/assets/js/jquery-3.6.0.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="/assets/vendor/php-email-form/validate.js"></script>
<script src="/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
<script src="/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="/assets/vendor/venobox/venobox.min.js"></script>
<script src="/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="/assets/vendor/aos/aos.js"></script>
<script src="/assets/vendor/ckeditor/ckeditor.js"></script>

<!-- Template Main JS File -->
<script src="/assets/js/main.js"></script>

<script src="/assets/DataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="/assets/DataTables/responsive/js/responsive.bootstrap4.min.js"></script>

<script src="/assets/js/app.js"></script>

<script src="/assets/js/jquery.blockUI.js"></script>
<!-- <script src="/assets/js/sweetalert.js"></script> -->
<script src="/assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="/assets/select2/dist/js/select2.min.js"></script>
<script src="/assets/js/custom.js"></script>

@include('layouts.partials.footer-jsfunctions')

<script>
  
  let idleTimeout;

  function resetIdleTimer() {
    clearTimeout(idleTimeout);
    idleTimeout = setTimeout(function() {
      window.location.href = "{{ route('signout') }}"; // Redirect to logout page
    }, 5 * 60 * 1000); // Idle timeout duration in milliseconds (e.g., 30 minutes)
  }
</script>

@if(auth()->user())
<script>
  // Initialize idle timer on page load
  resetIdleTimer();

  // Add event listeners for user activity (e.g., mousemove, keydown, click)
  document.addEventListener('mousemove', resetIdleTimer);
  document.addEventListener('keydown', resetIdleTimer);
  document.addEventListener('click', resetIdleTimer);
</script>
@endif


@if ($message = Session::get('success'))
<script>
  Swal.fire(
    "Successful",
    "{{ $message }}",
    "success"
  )
</script>
@endif

@if ($message = Session::get('error'))
<script>
  Swal.fire(
    "Warning",
    "{{ $message }}",
    "warning"
  )
</script>
@endif


<script type="text/javascript">
 
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


 
</script>
<!-- @livewireStyles -->