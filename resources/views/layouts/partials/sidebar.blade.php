<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/dashboard">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
                <path d="M19.4,4.1l-9-4C10.1,0,9.9,0,9.6,0.1l-9,4C0.2,4.2,0,4.6,0,5s0.2,0.8,0.6,0.9l9,4C9.7,10,9.9,10,10,10s0.3,0,0.4-0.1l9-4
              C19.8,5.8,20,5.4,20,5S19.8,4.2,19.4,4.1z" />
                <path d="M10,15c-0.1,0-0.3,0-0.4-0.1l-9-4c-0.5-0.2-0.7-0.8-0.5-1.3c0.2-0.5,0.8-0.7,1.3-0.5l8.6,3.8l8.6-3.8c0.5-0.2,1.1,0,1.3,0.5
              c0.2,0.5,0,1.1-0.5,1.3l-9,4C10.3,15,10.1,15,10,15z" />
                <path d="M10,20c-0.1,0-0.3,0-0.4-0.1l-9-4c-0.5-0.2-0.7-0.8-0.5-1.3c0.2-0.5,0.8-0.7,1.3-0.5l8.6,3.8l8.6-3.8c0.5-0.2,1.1,0,1.3,0.5
              c0.2,0.5,0,1.1-0.5,1.3l-9,4C10.3,20,10.1,20,10,20z" />
            </svg>

            <span class="align-middle me-3">APRODIGITALS</span>
        </a>

        <ul class="sidebar-nav">

            <li class="sidebar-item">
                <a data-bs-target="#dashboard" class="sidebar-link">
                    <i class="align-middle"></i> <span class="align-middle">Dashboard</span>
                    <span class="badge badge-sidebar-primary"></span>
                </a>

            </li>
            <li class="sidebar-item">
                <a data-bs-target="#dashboards" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Blog Posts</span>
                    <span class="badge badge-sidebar-primary"></span>
                </a>
                <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.categories') }}">Manage Categories</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('blog.create') }}">Add New Post</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="/admin/blog">View All Posts</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Manage Comments</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#settings" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">System Settings</span>
                    <span class="badge badge-sidebar-primary"></span>
                </a>
                <ul id="settings" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('positions.create') }}">New Position</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('positions.index') }}">Position List</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#staff_payroll" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Staff Payroll</span>
                    <span class="badge badge-sidebar-primary"></span>
                </a>
                <ul id="staff_payroll" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('payroll.overview') }}">Payroll Overview</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Salary Adjustment</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Adjustments</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Salary Increment</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Salary Increment History</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Allowances</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Staff Allowance</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Staff Allowance List</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Deductions</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Staff Deduction</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Staff Deductions List</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('loans.types') }}">Loan Types</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('loans.setup') }}">New Loan Application</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Loan Repayments</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Manage Loan Application</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Loan Repayment Reschedule</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Loan Applications</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Active Loans</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.comments') }}">Staff Loan Repayment</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('payroll.setup-form') }}">Payroll Setup</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('payroll.payroll-list') }}">Payroll List</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#users" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Users Management</span>
                    <span class="badge badge-sidebar-primary"></span>
                </a>
                <ul id="users" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('user.form') }}">Add New User</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('user.upload-form') }}">Users Bulk Upload</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('admin.users') }}">View All Users</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#business" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Business Management</span>
                    <span class="badge badge-sidebar-primary"></span>
                </a>
                <ul id="business" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('business.form') }}">Add New Business</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ route('manage-businesses') }}">View All Business</a></li>
                </ul>
            </li>

        </ul>

        <!-- <div class="sidebar-bottom d-none d-lg-block">
            <div class="media">
                <img class="rounded-circle mr-3" src="/assets/img/avatars/avatar.jpg" alt="Chris Wood" width="40" height="40">
                <div class="media-body">
                    <h6 style="color: white;" class="mb-1">Chris Wood</h6>

                    <div>
                        <button class="btn btn-danger btn-block" onclick="window.location='logout.php'">Logout</button>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</nav>