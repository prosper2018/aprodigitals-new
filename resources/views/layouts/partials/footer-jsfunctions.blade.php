<script>
    var loanapplications;
    $(function() {

        loanapplications = $('#loan-loanapplications').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            select: {
                style: "os",
                selector: "td:first-child",
            },
            className: "dt-body-center dt-head-center",
            ajax: {
                url: "{{ route('loans.applications') }}",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.filter_type = $('select#filter_type').children('option:selected').val();
                }
            },
            columns: [{
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'photo',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        if (row.photo && row.photo !== '') {
                            var img = new Image();
                            img.src = '/' + row.photo;

                            img.onload = function() {
                                if (this.naturalWidth > 0) {
                                    return '<img src="' + row.photo + '" alt="Business Logo" width="50px" height="50px">';
                                } else {
                                    var avartar = (row.gender == 'Male' || row.gender == 'male' || row.gender == 'MALE') ? 'avartar-m' : 'avartar-f';
                                    var path = "/assets/img/" + avartar + ".png";
                                    return '<img src="' + path + '" alt="Business Logo" width="50px" height="50px">';
                                }
                            };

                            img.onerror = function() {
                                var avartar = (row.gender == 'Male' || row.gender == 'male' || row.gender == 'MALE') ? 'avartar-m' : 'avartar-f';
                                var path = "/assets/img/" + avartar + ".png";
                                return '<img src="' + path + '" alt="Business Logo" width="50px" height="50px">';
                            };
                        } else {
                            var avartar = (row.gender == 'Male' || row.gender == 'male' || row.gender == 'MALE') ? 'avartar-m' : 'avartar-f';
                            var path = "/assets/img/" + avartar + ".png";
                            return '<img src="' + path + '" alt="Business Logo" width="50px" height="50px">';
                        }
                    }
                },
                {
                    data: 'display_name',
                    name: 'users.display_name',
                    searchable: false
                },
                {
                    data: 'ref_no',
                    name: 'loan_applications.ref_no'
                },
                {
                    data: 'app_status',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        if (row.app_status == 300) {
                            return '<span class="badge bg-danger">Rejected</span>';
                        } else if (row.app_status == 200) {
                            return '<span class="badge bg-success">Active</span>';
                        } else {
                            return '<span class="badge bg-warning">Pending</span>';
                        };
                    }
                },
                {
                    data: 'reason',
                    name: 'loan_applications.reason'
                },
                {
                    data: 'amount',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        return number_format(row.amount);
                    }
                },
                {
                    data: 'submitted_by_name',
                    searchable: false,
                    name: 'submitted_by_name'
                },
                {
                    data: 'created_at',
                    name: 'loan_applications.created_at'
                },
                {
                    data: 'start_date',
                    name: 'loan_applications.start_date'
                },
                {
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        var action = '<div class="btn-group col-md-2"><button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button><div class="dropdown-menu">';

                        action += (row.app_status == 100) ? '<a class="dropdown-item" href="' + row.id + '/edit">Edit</a>' : '';

                        action += (row.app_status == 100) ? '<a class="dropdown-item" href="javascript:void(0)" onclick="oneLoanActions(' + row.id +
                            ', \'delete\')">Delete</a>' : '';

                        action += '<a class="dropdown-item" href="' + row.id + '/view">View</a>';

                        action += '</div></div>';
                        return action;
                    }
                },
            ]
        });
    });

    $('#apply_loan_applications_filter').click(function() {
        loanapplications.ajax.reload(); // Reload the DataTable with the new filter
    });

    var manageloans;
    $(function() {

        manageloans = $('#manage-loans').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            select: {
                style: "os",
                selector: "td:first-child",
            },
            className: "dt-body-center dt-head-center",
            ajax: {
                url: "{{ route('loans.manage.list') }}",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.filter_type = $('select#filter_type').children('option:selected').val();
                }
            },
            columns: [{
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return '<input type="checkbox" class="checkid" name="selected_loans[]" value="' + row.id + '">';
                    },
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'photo',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        if (row.photo && row.photo !== '') {
                            var img = new Image();
                            img.src = '/' + row.photo;

                            img.onload = function() {
                                if (this.naturalWidth > 0) {
                                    return '<img src="' + row.photo + '" alt="Business Logo" width="50px" height="50px">';
                                } else {
                                    var avartar = (row.gender == 'Male' || row.gender == 'male' || row.gender == 'MALE') ? 'avartar-m' : 'avartar-f';
                                    var path = "/assets/img/" + avartar + ".png";
                                    return '<img src="' + path + '" alt="Business Logo" width="50px" height="50px">';
                                }
                            };

                            img.onerror = function() {
                                var avartar = (row.gender == 'Male' || row.gender == 'male' || row.gender == 'MALE') ? 'avartar-m' : 'avartar-f';
                                var path = "/assets/img/" + avartar + ".png";
                                return '<img src="' + path + '" alt="Business Logo" width="50px" height="50px">';
                            };
                        } else {
                            var avartar = (row.gender == 'Male' || row.gender == 'male' || row.gender == 'MALE') ? 'avartar-m' : 'avartar-f';
                            var path = "/assets/img/" + avartar + ".png";
                            return '<img src="' + path + '" alt="Business Logo" width="50px" height="50px">';
                        }
                    }
                },
                {
                    data: 'display_name',
                    name: 'users.display_name',
                    searchable: false
                },
                {
                    data: 'ref_no',
                    name: 'loan_applications.ref_no'
                },
                {
                    data: 'app_status',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        if (row.app_status == 300) {
                            return '<span class="badge bg-danger">Rejected</span>';
                        } else if (row.app_status == 200) {
                            return '<span class="badge bg-success">Active</span>';
                        } else {
                            return '<span class="badge bg-warning">Pending</span>';
                        };
                    }
                },
                {
                    data: 'reason',
                    name: 'loan_applications.reason'
                },
                {
                    data: 'amount',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        return number_format(row.amount);
                    }
                },
                {
                    data: 'submitted_by',
                    name: 'loan_applications.submitted_by'
                },
                {
                    data: 'created_at',
                    name: 'loan_applications.created_at'
                },
                {
                    data: 'start_date',
                    name: 'loan_applications.start_date'
                },
                {
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div class="btn-group col-md-2"><button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button><div class="dropdown-menu"><a class="dropdown-item" href="javascript:void(0)" onclick="oneLoanActions(' + row.id +
                            ', \'approve\')">Approve</a><a class="dropdown-item" href="javascript:void(0)" onclick="oneLoanActions(' + row.id +
                            ', \'delete\')">Delete</a><a class="dropdown-item" href="javascript:void(0)" onclick="oneLoanActions(' + row.id +
                            ', \'reject\')">Reject</a><a class="dropdown-item" href="' + row.id + '/view">View</a></div></div>';
                    }
                },
            ]
        });
    });

    $('#apply_manage_loan_filter').click(function() {
        manageloans.ajax.reload(); // Reload the DataTable with the new filter
    });


    function oneLoanActions(ref, action_type) {

        var action = action_type.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
        if (ref == "") {
            Swal.fire({
                text: "You have not selected any record, please select a record!",
                icon: "info",
            });
        } else {
            var label = getActionLabel(action_type, "Loan", "single");
            jQuery(function validation() {
                Swal.fire({
                    title: action + "?",
                    text: label,
                    icon: "warning",
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        if (action_type == "reject") {
                            $("#rejected_id").val(ref);
                            $("#confirmRejecton").modal("show");
                        } else {
                            $.ajax({
                                url: "{{ route('loans.manage.single-action') }}",
                                type: "POST",
                                data: {
                                    ids: ref,
                                    type: action_type,
                                },
                                dataType: "json",
                                beforeSend: function() {
                                    $.blockUI({
                                        message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
                                    });
                                },
                                success: function(response) {
                                    manageloans.ajax.reload();
                                    loanapplications.ajax.reload();
                                    $.unblockUI();
                                    if (response.response_code == 0) {
                                        Swal.fire("Success", response.response_message, "success");
                                    } else {
                                        Swal.fire("Error", response.response_message, "warning");
                                    }
                                },
                                error: function(response) {
                                    $.unblockUI();
                                    manageloans.ajax.reload();
                                    loanapplications.ajax.reload();
                                    Swal.fire(
                                        "Error",
                                        "Something went wrong..... Please try agian!",
                                        "error"
                                    );
                                },
                            });
                        }
                    } else {}
                });
            });
        }
    }

    function loanActions(action_type) {

        var action = action_type.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
        var ids = [];
        $(".checkid").each(function() {
            if ($(this).is(":checked")) {
                ids.push($(this).val());
            }
        });
        $(".ids").val(ids).serialize();
        var id = $(".ids").val();

        if (id == "") {
            Swal.fire({
                text: "You have not selected any record, please select a record!",
                icon: "info",
            });
        } else {
            var label = getActionLabel(action_type, "Loan");
            jQuery(function validation() {
                Swal.fire({
                    title: action + "?",
                    text: label,
                    icon: "warning",
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        if (action_type == "reject") {
                            $("#rejected_id").val(id);
                            $("#confirmRejecton").modal("show");
                        } else {
                            $.ajax({
                                url: "{{ route('loans.manage.multi-action') }}",
                                type: "POST",
                                data: {
                                    ids: id,
                                    type: action_type,
                                },
                                dataType: "json",
                                beforeSend: function() {
                                    $.blockUI({
                                        message: '<img src="assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
                                    });
                                },
                                success: function(response) {
                                    $.unblockUI();
                                    manageloans.ajax.reload();
                                    loanapplications.ajax.reload();
                                    if (response.response_code == 0) {
                                        Swal.fire("Success", response.response_message, "success");
                                    } else {
                                        Swal.fire("Error", response.response_message, "warning");
                                    }
                                },
                                error: function(response) {
                                    $.unblockUI();
                                    manageloans.ajax.reload();
                                    loanapplications.ajax.reload();
                                    Swal.fire(
                                        "Error",
                                        "Something went wrong..... Please try agian!",
                                        "error"
                                    );
                                },
                            });
                        }
                    } else {}
                });
            });
        }
    }

    var loantypes;
    $(function() {

        loantypes = $('#loan-types-datatables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            select: {
                style: "os",
                selector: "td:first-child",
            },
            className: "dt-body-center dt-head-center",
            ajax: {
                url: "{{ route('loans.types.viewall') }}",
                data: function(d) {
                    // d.business_name = $('#business_name').val();
                    // d.status = $('#status').val();
                }
            },
            columns: [{
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'display_name',
                    name: 'loan_types.display_name'
                },
                {
                    data: 'description',
                    name: 'loan_types.description',
                },
                {
                    data: 'created_at',
                    name: 'loan_types.created_at'
                },
                {
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        var action = '';

                        action = '<a class="btn btn-sm btn-outline-primary edit_loantype" href = "' + row.id + '/types" data-id="' + row.id + '" type="button"><i class="fa fa-edit"></i></a><button class = "btn btn-sm btn-outline-danger remove_loantype" data-id = "' + row.id + '" type = "button" onclick = "deleteLoanTypes(' + row.id + ', \'Payroll\')" ><i class = "fa fa-trash"></i></button >';

                        return action;
                    }
                }
            ]
        });
    });

    $('#apply_payroll_filter').click(function() {
        loantypes.ajax.reload(); // Reload the DataTable with the new filter
    });

    function deleteLoanTypes(id) {

        jQuery(function validation() {
            Swal.fire({
                title: "Delete?",
                text: "By clicking OK, The selected loan type will be Deleted",
                icon: "warning",
                buttons: true,
                deleteMode: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {

                    $.ajax({
                        url: "{{ route('loans.types.delete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $.blockUI({
                                message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
                            });
                        },
                        success: function(response) {
                            loantypes.ajax.reload();
                            $.unblockUI();
                            if (response.response_code == 0) {
                                Swal.fire("Success", response.response_message, "success");
                            } else {
                                Swal.fire("Warning", response.response_message, "warning");
                            }
                        },
                        error: function(response) {
                            $.unblockUI();
                            loantypes.ajax.reload()
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


    var payrolls;
    $(function() {

        payrolls = $('#payroll-list').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            select: {
                style: "os",
                selector: "td:first-child",
            },
            className: "dt-body-center dt-head-center",
            ajax: {
                url: "{{ route('payroll.payroll-list') }}",
                data: function(d) {
                    // d.business_name = $('#business_name').val();
                    // d.status = $('#status').val();
                }
            },
            columns: [{
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'ref_no',
                    name: 'payrolls.ref_no'
                },
                {
                    data: 'payroll_type',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        if (row.payroll_type == 1) {
                            return '<span class="badge bg-primary">Monthly</span>';
                        } else if (row.payroll_type == 2) {
                            return '<span class="badge bg-secondary">Semi-Monthly</span>';
                        } else {
                            return '<span class="badge bg-danger">Not Defined</span>';
                        };
                    }
                },
                {
                    data: 'date_from',
                    name: 'payrolls.date_from'
                },
                {
                    data: 'date_to',
                    name: 'payrolls.date_to'
                },
                {
                    data: 'status',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        if (row.status == 1) {
                            return '<span class="badge bg-warning">Computed</span>';
                        } else if (row.status == 2) {
                            return '<span class="badge bg-success">Active</span>';
                        } else {
                            return '<span class="badge bg-danger">New</span>';
                        };
                    }
                },
                {
                    data: 'created_at',
                    name: 'payrolls.created_at'
                },
                {
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        var action = '';
                        if (row.status == 0) {
                            action += '<button class="btn btn-sm btn-outline-primary calculate_payroll" data-id="' + row.id +
                                '" type="button" onclick = "calculatePayroll(' + row.id +
                                ', \'Payroll\', \'Calculate\')" data-id="' + row.id +
                                '">Calculate</button>';
                        } else {
                            action += '<a class="btn btn-sm btn-outline-primary view_payroll" href = "payroll/' + row.id + '/view" data-id="' + row.id + '" type="button"><i class="fa fa-eye"></i></a>';
                        }

                        action += (row.status != 2) ? '<a class="btn btn-sm btn-outline-primary edit_payroll" href = "payroll/' + row.id + '/edit" data-id="' + row.id + '" type="button"><i class="fa fa-edit"></i></a><button class = "btn btn-sm btn-outline-danger remove_payroll" data-id = "' + row.id + '" type = "button" onclick = "deletePayroll(' + row.id + ', \'Payroll\')" ><i class = "fa fa-trash"></i></button >' : '';

                        return action;
                    }
                }
            ]
        });
    });

    $('#apply_payroll_filter').click(function() {
        payrolls.ajax.reload(); // Reload the DataTable with the new filter
    });

    function deletePayroll(id) {

        jQuery(function validation() {
            Swal.fire({
                title: "Delete?",
                text: "By clicking OK, The selected payroll will be Deleted",
                icon: "warning",
                buttons: true,
                deleteMode: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $.ajax({
                        url: "{{ route('payroll.delete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $.blockUI({
                                message: '<img src="/assets/img/loading.gif" alt=""/>&nbsp;&nbsp;processing request please wait . . .',
                            });
                        },
                        success: function(response) {
                            payrolls.ajax.reload();
                            $.unblockUI();
                            if (response.response_code == 0) {
                                Swal.fire("Success", response.response_message, "success");
                            } else {
                                Swal.fire("Warning", response.response_message, "warning");
                            }
                        },
                        error: function(response) {
                            $.unblockUI();
                            payrolls.ajax.reload()
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



    function getPayrollOverview() {
        var staff_id = $("#staff_id").val(),
            department_id = $("select#department_id").children("option:selected").val(),
            month = $("#month").val(),
            position_id = $("select#position_id").children("option:selected").val(),
            business_id = $("select#business_id").children("option:selected").val(),
            data = {
                staff_id: staff_id,
                department_id: department_id,
                month: month,
                position_id: position_id,
                business_id: business_id,
            };

        $.ajax({
            url: "{{ route('payroll.overview') }}",
            type: "post",
            data: data,
            dataType: "json",
            success: function(result) {

                $("#active_staff").html(result.total_staff);
                $("#total_salary").html(result.total_salary);
            },
            error: function() {
                Swal.fire("Error!", "An error occured!", "warning");
            },
        });
    }

    function getBankAccount() {
        var bank_code = $("select#bank_code").children("option:selected").val(),
            bank_account_no = $("#bank_account_no").val();
        if (bank_code != "" && bank_account_no != "") {
            var data = {
                bank_code: bank_code,
                bank_account_no: bank_account_no,
            };
            $("#spinner").show();
            $.ajax({
                url: "{{ route('api.account_validation') }}",
                type: "get",
                data: data,
                dataType: "json",
                success: function(data) {
                    $("#spinner").hide();
                    if (data.response_code == 0) {
                        $("#bank_account_name").prop(
                            "value",
                            data.response_message
                        );
                    } else {
                        Swal.fire("Attention!", data.response_message, "info");
                    }
                },
                error: function() {
                    $("#spinner").hide();
                    Swal.fire(
                        "Error",
                        "Opps! Something doesn't right... Please, try again.",
                        "error"
                    );
                },
            });
        }
    }

    function updateRoleOptions() {
        var departmentSelect = document.getElementById("department_id");
        var positionSelect = document.getElementById("position_id");
        var selectedDepartment = departmentSelect.value;

        // Clear existing options
        positionSelect.innerHTML = "";

        // Make an AJAX request to fetch roles based on selected department
        fetch('{{ route("get.roles", ["department" => "__department_id"]) }}'.replace('__department_id', selectedDepartment))
            .then(response => response.json())
            .then(data => {
                // Clear existing options
                positionSelect.innerHTML = '';

                // Populate options based on the response
                positionSelect.appendChild(new Option('::Select Position::', '')); // Add a default option
                for (var positionId in data) {
                    var option = document.createElement('option');
                    option.value = positionId;
                    option.text = data[positionId];
                    positionSelect.appendChild(option);
                }
            })
            .catch(error => console.error('Error:', error));
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
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
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
                        return '<img src="/' + row.logo + '" alt="Business Logo" width="50px" height="50px">';
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
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
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
                        return '<a data-id="' + row.id + '" href="/admin/users/' + row.id + '/edit" class="edit btn btn-success btn-sm">Edit</a>&nbsp;&nbsp;<a data-id="' + row.id + '" href="/admin/users/' + row.id + '/profile-view" class="view btn btn-info btn-sm">View</a>&nbsp;&nbsp;<button data-id="{{ "' + row.id + '"}}" class="delete  btn btn-danger btn-sm" onclick="delete_user(this)">Delete</button>';
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
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
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
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
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
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
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

    function getStaffByDept(dept_id) {
        $.ajax({
            type: "get",
            url: "{{ route('user.department') }}",
            data: {
                dept_id: dept_id
            },
            dataType: "json",
            success: function(data) {

                $("#staff_id")
                    .attr("disabled", false)
                    .html("<option value='' selected>::: SELECT :::</option>");

                if (data.option_value.length != 0) {
                    for (var i = 0; i < data.option_value.length; i++) {
                        $("#staff_id").append(
                            '<option value="' +
                            data.option_id[i] +
                            '">' +
                            data.option_value[i] +
                            "</option>"
                        );
                    }
                } else {
                    $("#staff_id")
                        .attr("disabled", false)
                        .html("<option value=''>No Staff in Department</option>");
                }
                //  Swal.fire("Successful!", data, "success");
            },
            error: function(data) {
                //  Swal.fire("Ooops!", "Operation Failed! Try again", "error");
            },
        });
    }
</script>