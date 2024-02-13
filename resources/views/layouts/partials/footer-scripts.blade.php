<a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
<div id="preloader"></div>

<!-- <script src="{{ asset('js/app.js') }}"></script> -->

<!-- Vendor JS Files -->
<script src="/assets/js/jquery-3.6.0.min.js"></script>
<!-- <script src="/assets/vendor/jquery/jquery.min.js"></script> -->
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


<script>
  let idleTimeout;

  function resetIdleTimer() {
    clearTimeout(idleTimeout);
    idleTimeout = setTimeout(function() {
      window.location.href = "{{ route('signout') }}"; // Redirect to logout page
    }, 5 * 60 * 1000); // Idle timeout duration in milliseconds (e.g., 30 minutes)
  }


  // Initialize idle timer on page load
  resetIdleTimer();


  // Add event listeners for user activity (e.g., mousemove, keydown, click)
  document.addEventListener('mousemove', resetIdleTimer);
  document.addEventListener('keydown', resetIdleTimer);
  document.addEventListener('click', resetIdleTimer);



  document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById("chartjs-dashboard-bar")) {
      // Bar chart
      new Chart(document.getElementById("chartjs-dashboard-bar"), {
        type: "bar",
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Last year",
            backgroundColor: window.theme.primary,
            borderColor: window.theme.primary,
            hoverBackgroundColor: window.theme.primary,
            hoverBorderColor: window.theme.primary,
            data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
            barPercentage: .325,
            categoryPercentage: .5
          }, {
            label: "This year",
            backgroundColor: window.theme["primary-light"],
            borderColor: window.theme["primary-light"],
            hoverBackgroundColor: window.theme["primary-light"],
            hoverBorderColor: window.theme["primary-light"],
            data: [69, 66, 24, 48, 52, 51, 44, 53, 62, 79, 51, 68],
            barPercentage: .325,
            categoryPercentage: .5
          }]
        },
        options: {
          maintainAspectRatio: false,
          cornerRadius: 15,
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              gridLines: {
                display: false
              },
              ticks: {
                stepSize: 20
              },
              stacked: true,
            }],
            xAxes: [{
              gridLines: {
                color: "transparent"
              },
              stacked: true,
            }]
          }
        }
      });
    }
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById("datetimepicker-dashboard")) {
      $("#datetimepicker-dashboard").datetimepicker({
        inline: true,
        sideBySide: false,
        format: "L"
      });
    }
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById("chartjs-dashboard-pie")) {
      // Pie chart
      new Chart(document.getElementById("chartjs-dashboard-pie"), {
        type: "pie",
        data: {
          labels: ["Direct", "Affiliate", "E-mail", "Other"],
          datasets: [{
            data: [2602, 1253, 541, 1465],
            backgroundColor: [
              window.theme.primary,
              window.theme.warning,
              window.theme.danger,
              "#E8EAED"
            ],
            borderWidth: 5,
            borderColor: window.theme.white
          }]
        },
        options: {
          responsive: !window.MSInputMethodContext,
          maintainAspectRatio: false,
          cutoutPercentage: 70,
          legend: {
            display: false
          }
        }
      });
    }
  });
</script>
<script>
  function handleFileInput(inputId, previewId) {
    var fileInput = document.getElementById(inputId);
    var preview = document.getElementById(previewId);

    function previewFile() {
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    }

    fileInput.addEventListener('change', previewFile);

    // Check if file input already has a file selected when the page loads
    if (fileInput.files.length > 0) {
      previewFile();
    }
  }



  document.addEventListener("DOMContentLoaded", function() {
    $("#datatables-dashboard-projects").DataTable({
      pageLength: 6,
      lengthChange: false,
      bFilter: false,
      autoWidth: false
    });
  });

  function togglePasswordVisibility(fieldId, iconId) {
    const passwordField = document.getElementById(fieldId);
    const visibilityIcon = document.getElementById(iconId);

    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      visibilityIcon.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Font Awesome Eye Slash Icon
    } else {
      passwordField.type = 'password';
      visibilityIcon.innerHTML = '<i class="fas fa-eye"></i>'; // Font Awesome Eye Icon
    }
  }
</script>

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

<script>
  select();
  if (document.getElementById('page_1')) {
    CKEDITOR.replace('page_1');
  }

  if (document.getElementById('page_2')) {
    CKEDITOR.replace('page_2');
  }

  if (document.getElementById('post_content_excerpt')) {
    CKEDITOR.replace('post_content_excerpt');
  }
</script>



<script type="text/javascript">
  function number_format(number, decimals = 2, decimalSeparator = '.', thousandSeparator = ',') {
    number = parseFloat(number);

    if (isNaN(number) || !isFinite(number)) {
      return '0.00';
    }

    // Round to specified number of decimal places
    number = number.toFixed(decimals);

    // Add thousands separator
    number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1' + thousandSeparator);

    // Replace decimal separator
    number = number.replace('.', decimalSeparator);

    return number;
  }


  var businesses;
  $(function() {

    businesses = $('#all-businesses').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      select: {
        style: "os",
        selector: "td:first-child",
      },
      className: "dt-body-center dt-head-center",
      ajax: {
        url: "{{ route('businesses-list') }}",
        data: function(d) {
          d.business_name = $('#business_name').val();
          d.status = $('#status').val();
        }
      },
      columns: [{
          data: 'id',
          name: 'business_details.id'
        },
        {
          data: 'business_name',
          name: 'business_details.business_name'
        },
        {
          data: 'logo',
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return '<img src="/assets' + row.logo + '" alt="Business Logo" width="50px" height="50px">';
          }
        },
        {
          data: 'address',
          name: 'business_details.address'
        },
        {
          data: 'description',
          name: 'business_details.description'
        },
        {
          data: 'total_staff',
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return number_format(row.total_staff);
          }
        },
        {
          data: 'total_active_staff',
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return number_format(row.total_active_staff);
          }
        },
        {
          data: 'total_salary',
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return number_format(row.total_salary);
          }
        },
        {
          data: 'is_deleted',
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return (row.is_deleted == 1) ? '<span class="badge bg-danger">Inactive</span>' : '<span class="badge bg-success">Active</span>';
          }
        },
        {
          data: 'created_at',
          name: 'business_details.created_at'
        },
        {
          data: null,
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return '<a class="btn btn-success" href="/businesses/' + row.id + '/edit">Edit</a>' +
              '<button data-id="' + row.id + '" class="btn btn-danger" onclick="delete_business(this)">Delete</button>';
          }
        }
      ]
    });
  });

  $('#apply_business_filter').click(function() {
    businesses.ajax.reload(); // Reload the DataTable with the new filter
  });


  $(function() {

    users_table = $('.allusers').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      select: {
        style: "os",
        selector: "td:first-child",
      },
      className: "dt-body-center dt-head-center",
      ajax: "{{ route('admin.users') }}",
      columns: [{
          data: 'id',
          name: 'users.id'
        },
        {
          data: 'username',
          name: 'users.username'
        },
        {
          data: 'firstname',
          name: 'users.firstname'
        },
        {
          data: 'lastname',
          name: 'users.lastname'
        },
        {
          data: 'mobile_phone',
          name: 'users.mobile_phone'
        },
        {
          data: 'position_name',
          name: 'positions.position_name'
        },
        {
          data: 'email',
          name: 'users.email'
        },
        {
          data: 'pin_missed',
          name: 'users.pin_missed'
        },
        {
          data: 'login_status',
          name: 'users.login_status'
        },
        {
          data: null,
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return '<a data-id="' + row.id + '" href="/blog/' + row.id + '/edit" class="edit btn btn-success btn-sm">Edit</a><button data-id="{{ "' + row.id + '"}}" class="delete  btn btn-danger btn-sm" onclick="delete_post(this)">Delete</button>';
          }
        },
        {
          data: 'created_at',
          name: 'users.created_at'
        },

      ]
    });


  });


  var categories_table;
  $(function() {

    categories_table = $('.allcategories').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      select: {
        style: "os",
        selector: "td:first-child",
      },
      className: "dt-body-center dt-head-center",
      ajax: "{{ route('admin.categories') }}",
      columns: [{
          data: 'id',
          name: 'categories.id'
        },
        {
          data: 'id',
          render: function(data, type, row) {
            return '<input type="checkbox" class="checkid" name="selected_post[]" value="' + row.id + '">';
          },
          searchable: false,
          orderable: false
        },
        {
          data: 'cat_title',
          name: 'categories.cat_title'
        },
        {
          data: 'created_at',
          name: 'comments.created_at'
        },
        {
          data: null,
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return '<a data-id="' + row.id + '" href="/admin/' + row.id + '/categories" class="edit btn btn-success btn-sm">Edit</a><button data-id="{{ "' + row.id + '"}}" class="delete  btn btn-danger btn-sm" onclick="delete_post(this)">Delete</button>';
          }
        },
      ]
    });


  });

  var comments_table;
  $(function() {

    comments_table = $('.allcomments').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      select: {
        style: "os",
        selector: "td:first-child",
      },
      className: "dt-body-center dt-head-center",
      ajax: "{{ route('admin.comments') }}",
      columns: [{
          data: 'id',
          name: 'comments.id'
        },
        {
          data: 'id',
          render: function(data, type, row) {
            return '<input type="checkbox" class="checkid" name="selected_post[]" value="' + row.id + '">';
          },
          searchable: false,
          orderable: false
        },
        {
          data: 'comment_author',
          name: 'comments.comment_author'
        },
        {
          data: 'comment_content',
          name: 'comments.comment_content'
        },
        {
          data: 'comment_email',
          name: 'comments.comment_email'
        },
        {
          data: 'title',
          name: 'blog_posts.title',
          render: function(data, type, row) {
            return "<a href='/blog/" + row.comment_post_id + "/page_1'>" + row.title + "</a>"
          }
        },
        {
          data: 'comment_status',
          name: 'comments.comment_status'
        },
        {
          data: 'created_at',
          name: 'comments.created_at'
        },
        {
          data: null,
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return '<button data-id="' + row.id + '" class="delete  btn btn-danger btn-sm" onclick="delete_comment(this)">Delete</button>';
          }
        },
      ]
    });


  });


  var table;
  $(function() {

    table = $('.allpost').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      select: {
        style: "os",
        selector: "td:first-child",
      },
      className: "dt-body-center dt-head-center",
      ajax: "{{ route('admin.blog') }}",
      columns: [{
          data: 'id',
          name: 'blog_posts.id'
        },
        {
          data: 'id',
          render: function(data, type, row) {
            return '<input type="checkbox" class="checkid" name="selected_post[]" value="' + row.id + '">';
          },
          searchable: false,
          orderable: false
        },
        {
          data: 'name',
          name: 'users.name',
          searchable: false
        },
        {
          data: 'title',
          name: 'blog_posts.title'
        },
        {
          data: 'cat_title',
          name: 'categories.cat_title'
        },
        {
          data: 'post_status',
          name: 'blog_posts.post_status'
        },
        {
          data: 'post_image',
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return '<img src="/images/' + row.post_image + '" alt="Post Image" width="50px" height="50px">';
          }
        },
        {
          data: 'post_tags',
          name: 'blog_posts.post_tags'
        },
        {
          data: 'post_comment_count',
          name: 'blog_posts.post_comment_count'
        },
        {
          data: 'post_views_count',
          name: 'blog_posts.post_views_count'
        },
        {
          data: 'created_at',
          name: 'blog_posts.created_at'
        },
        {
          data: null,
          searchable: false,
          orderable: false,
          render: function(data, type, row) {
            return '<a data-id="' + row.id + '" href="/blog/' + row.id + '/page_1" class="edit btn btn-info btn-sm">View</a>&nbsp&nbsp<a data-id="' + row.id + '" href="/blog/' + row.id + '/edit" class="edit btn btn-success btn-sm">Edit</a>&nbsp&nbsp<button data-id="' + row.id + '" class="delete  btn btn-danger btn-sm" onclick="delete_post(this)">Delete</button>';
          }
        },
      ]
    });


  });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $("#selectAllBoxes").on("click", function() {
    var rows = table.rows().nodes();
    $('input[type="checkbox"]', rows).prop("checked", this.checked);
  });

  $("#selectAllCat").on("click", function() {
    var rows = categories_table.rows().nodes();
    $('input[type="checkbox"]', rows).prop("checked", this.checked);
  });

  $("#selectAllComm").on("click", function() {
    var rows = comments_table.rows().nodes();
    $('input[type="checkbox"]', rows).prop("checked", this.checked);
  })

  $(".post_views").on("click", function() {

    $.ajax({
      url: "{{ route('blog.views') }}",
      type: "POST",
      data: {
        _token: "{{ csrf_token() }}",
        id: this.dataset.id
      },
      dataType: "json",
      success: function(response) {
        // alert(response.response_message);
      },
      error: function(response) {
        // alert(response.response_message);
      },
    });
  });


  function delete_comment(id) {

    jQuery(function validation() {
      Swal.fire({
        title: "Delete?",
        text: "By clicking OK, The selected post comment(s) will be Deleted",
        icon: "warning",
        buttons: true,
        deleteMode: true,
      }).then((willDelete) => {
        if (willDelete.isConfirmed) {
          $.ajax({
            url: "{{ route('admin.comments.delete') }}",
            type: "POST",
            data: {
              _token: "{{ csrf_token() }}",
              id: id.dataset.id
            },
            dataType: "json",
            beforeSend: function() {
              $.blockUI({
                message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
              });
            },
            success: function(response) {
              $.unblockUI();
              if (response.response_code == 0) {
                Swal.fire("Success", response.response_message, "success");
                comments_table.draw();
              } else {
                Swal.fire("Warning", response.response_message, "warning");
                comments_table.draw();
              }
            },
            error: function(response) {
              $.unblockUI();
              comments_table.draw();
              Swal.fire(
                "Error",
                "Action could not be due to unknown error",
                "error"
              );

            },
          });
        } else {}
      });
    });
  }


  function delete_category(id) {

    jQuery(function validation() {
      Swal.fire({
        title: "Delete?",
        text: "By clicking OK, The selected post categories will be Deleted",
        icon: "warning",
        buttons: true,
        deleteMode: true,
      }).then((willDelete) => {
        if (willDelete.isConfirmed) {
          $.ajax({
            url: "{{ route('admin.categories.delete') }}",
            type: "POST",
            data: {
              _token: "{{ csrf_token() }}",
              id: id.dataset.id
            },
            dataType: "json",
            beforeSend: function() {
              $.blockUI({
                message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
              });
            },
            success: function(response) {
              $.unblockUI();
              if (response.response_code == 0) {
                Swal.fire("Success", response.response_message, "success");
                categories_table.draw();
              } else {
                Swal.fire("Warning", response.response_message, "warning");
                categories_table.draw();
              }
            },
            error: function(response) {
              $.unblockUI();
              categories_table.draw();
              Swal.fire(
                "Error",
                "Action could not be due to unknown error",
                "error"
              );

            },
          });
        } else {}
      });
    });
  }


  function delete_business(id) {

    jQuery(function validation() {
      Swal.fire({
        title: "Delete?",
        text: "By clicking OK, The selected business will be Deleted",
        icon: "warning",
        buttons: true,
        deleteMode: true,
      }).then((willDelete) => {
        if (willDelete.isConfirmed) {
          $.ajax({
            url: "{{ route('businesses.delete') }}",
            type: "POST",
            data: {
              _token: "{{ csrf_token() }}",
              id: id.dataset.id
            },
            dataType: "json",
            beforeSend: function() {
              $.blockUI({
                message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
              });
            },
            success: function(response) {
              businesses.ajax.reload();
              $.unblockUI();
              if (response.response_code == 0) {
                Swal.fire("Success", response.response_message, "success");
              } else {
                Swal.fire("Warning", response.response_message, "warning");
              }
            },
            error: function(response) {
              $.unblockUI();
              businesses.ajax.reload()
              Swal.fire(
                "Error",
                "Action could not be due to unknown error",
                "error"
              );

            },
          });
        } else {}
      });
    });
  }


  function delete_post(id) {

    jQuery(function validation() {
      Swal.fire({
        title: "Delete?",
        text: "By clicking OK, The selected posts will be Deleted",
        icon: "warning",
        buttons: true,
        deleteMode: true,
      }).then((willDelete) => {
        if (willDelete.isConfirmed) {
          $.ajax({
            url: "{{ route('admin.blog.delete') }}",
            type: "POST",
            data: {
              _token: "{{ csrf_token() }}",
              id: id.dataset.id
            },
            dataType: "json",
            beforeSend: function() {
              $.blockUI({
                message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
              });
            },
            success: function(response) {
              $.unblockUI();
              if (response.response_code == 0) {
                Swal.fire("Success", response.response_message, "success");
                table.draw();
              } else {
                Swal.fire("Warning", response.response_message, "warning");
                table.draw();
              }
            },
            error: function(response) {
              $.unblockUI();
              table.draw();
              Swal.fire(
                "Error",
                "Action could not be due to unknown error",
                "error"
              );

            },
          });
        } else {}
      });
    });
  }



  function delete_multi_category() {

    var ids = [],
      label = post_id = action = '';
    $(".checkid").each(function() {
      if ($(this).is(":checked")) {
        ids.push($(this).val());
      }
    });
    $("#cat_id").val(ids);
    post_id = $("#cat_id").val();

    action = "delete";
    label = "The selected posts will be Deleted";

    if (ids.length === 0) {
      Swal.fire({
        text: "You have not selected any record, please select a record!",
        icon: "info",
      });
    } else if (action == '') {
      Swal.fire({
        text: "You have not selected any action, please select an action to proceed!",
        icon: "info",
      });
    } else {
      jQuery(function validation() {
        Swal.fire({
          title: "Apply?",
          text: "By clicking OK, " + label,
          icon: "warning",
          buttons: true,
          deleteMode: true,
        }).then((willDelete) => {
          if (willDelete.isConfirmed) {
            $.ajax({
              url: "{{ route('category.apply') }}",
              type: "POST",
              data: {
                _token: "{{ csrf_token() }}",
                ids: post_id,
                action: action
              },
              dataType: "json",
              beforeSend: function() {
                $.blockUI({
                  message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
                });
              },
              success: function(response) {
                $.unblockUI();
                if (response.response_code == 0) {
                  Swal.fire("Success", response.response_message, "success");
                  categories_table.draw();
                } else {
                  Swal.fire("Warning", response.response_message, "warning");
                  categories_table.draw();
                }
              },
              error: function(response) {
                $.unblockUI();
                categories_table.draw();
                Swal.fire(
                  "Error",
                  "Action could not be due to unknown error",
                  "error"
                );

              },
            });
          } else {}
        });
      });
    }
  }

  function applyCommentAction() {

    var ids = [],
      label = post_id = action = '';
    $(".checkid").each(function() {
      if ($(this).is(":checked")) {
        ids.push($(this).val());
      }
    });
    $("#comment_id").val(ids)
    post_id = $("#comment_id").val();

    action = $("#action").children("option:selected").val();

    switch (action) {
      case 'approved':
        label = "The status of the selected post will be changed to Approved";
        break;
      case 'disapproved':
        label = "The status of the selected post will be changed to Published Disapproved";
        break;
      case 'delete':
        label = "The selected posts will be Deleted";
        break;
      default:
        day = "Invalid Action";
    }

    if (ids.length === 0) {
      Swal.fire({
        text: "You have not selected any record, please select a record!",
        icon: "info",
      });
    } else if (action == '') {
      Swal.fire({
        text: "You have not selected any action, please select an action to proceed!",
        icon: "info",
      });
    } else {
      jQuery(function validation() {
        Swal.fire({
          title: "Apply?",
          text: "By clicking OK, " + label,
          icon: "warning",
          buttons: true,
          deleteMode: true,
        }).then((willDelete) => {
          if (willDelete.isConfirmed) {
            $.ajax({
              url: "{{ route('comment.apply') }}",
              type: "POST",
              data: {
                _token: "{{ csrf_token() }}",
                ids: post_id,
                action: action
              },
              dataType: "json",
              beforeSend: function() {
                $.blockUI({
                  message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
                });
              },
              success: function(response) {
                $.unblockUI();
                if (response.response_code == 0) {
                  Swal.fire("Success", response.response_message, "success");
                  comments_table.draw();
                } else {
                  Swal.fire("Warning", response.response_message, "warning");
                  comments_table.draw();
                }
              },
              error: function(response) {
                $.unblockUI();
                comments_table.draw();
                Swal.fire(
                  "Error",
                  "Action could not be due to unknown error",
                  "error"
                );

              },
            });
          } else {}
        });
      });
    }
  }


  function applyAction() {

    var ids = [],
      label = post_id = action = '';
    $(".checkid").each(function() {
      if ($(this).is(":checked")) {
        ids.push($(this).val());
      }
    });
    $("#post_id").val(ids)
    post_id = $("#post_id").val();

    action = $("#action").children("option:selected").val();

    switch (action) {
      case 'published':
        label = "The status of the selected post will be changed to Published";
        break;
      case 'draft':
        label = "The status of the selected post will be changed to Published Draft";
        break;
      case 'delete':
        label = "The selected posts will be Deleted";
        break;
      case 'reset_view_count':
        label = "The views count for selected records will be Reset to zero(0)";
        break;
      default:
        day = "Invalid Action";
    }

    if (ids.length === 0) {
      Swal.fire({
        text: "You have not selected any record, please select a record!",
        icon: "info",
      });
    } else if (action == '') {
      Swal.fire({
        text: "You have not selected any action, please select an action to proceed!",
        icon: "info",
      });
    } else {
      jQuery(function validation() {
        Swal.fire({
          title: "Apply?",
          text: "By clicking OK, " + label,
          icon: "warning",
          buttons: true,
          deleteMode: true,
        }).then((willDelete) => {
          if (willDelete.isConfirmed) {
            $.ajax({
              url: "{{ route('blog.apply') }}",
              type: "POST",
              data: {
                _token: "{{ csrf_token() }}",
                ids: post_id,
                action: action
              },
              dataType: "json",
              beforeSend: function() {
                $.blockUI({
                  message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
                });
              },
              success: function(response) {
                $.unblockUI();
                if (response.response_code == 0) {
                  Swal.fire("Success", response.response_message, "success");
                  table.draw();
                } else {
                  Swal.fire("Warning", response.response_message, "warning");
                  table.draw();
                }
              },
              error: function(response) {
                $.unblockUI();
                table.draw();
                Swal.fire(
                  "Error",
                  "Action could not be due to unknown error",
                  "error"
                );

              },
            });
          } else {}
        });
      });
    }
  }
</script>
<!-- @livewireStyles -->