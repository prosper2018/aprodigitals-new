@extends('layouts.adminlayout')

@section('title', config("app.name").' - Payroll')

@section('content')

<section class="forms py-4">
    <div class="card card_border py-4 mb-4">
        <div class="card-body col-lg-12">
            <div class="row form-group">
                <div class="col-lg-4 col-md-4  col-sm-12">
                    <fieldset class="form-group">
                        <legend class="text-success">Filter Options</legend>
                    </fieldset>
                </div>
            </div>
            <div class="row" style="margin-bottom:0px">

                <div class="col-lg-2 col-md-2 col-sm-12 py-2" id="filter_div">
                    <label for="filter" style="color:forestgreen">Filter By:</label><br>
                    <select id="filter" class="form-control select">
                        <option value="">:: Select Option</option>
                        <option value="month">Month</option>
                        <option value="business_id">Business</option>
                        <option value="department_id">Department</option>
                        <option value="position_id">Position</option>
                        <option value="staff_id">Staff Name</option>
                        <option value="all">All Filters</option>
                        <input class="ids" type="hidden" id="ids" name="ids[]" value="" />
                    </select>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 py-2" id="month_div_id">
                    <label>Month</label>
                    <div class="state-section">
                        <input class="form-control" type="month" name="month" id="month" value="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 py-2" id="business_div_id">
                    <label>Business</label>
                    <select class="form-control select" name="business_id" data-toggle="select2" id="business_id">
                        <option value="">:::SELECT:::</option>
                        @foreach ($businesses as $row)
                        <option value="{{ $row->id }}">{{ $row->business_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 py-2" id="deparment_div_id">
                    <label>
                        Department
                    </label>
                    <select class="form-control select " onchange="updateRoleOptions()" name="department_id" data-toggle="select2" id="department_id">
                        <option value="">:::SELECT:::</option>
                        @foreach ($departments as $row)
                        <option value="{{ $row->id }}">{{ $row->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 py-2" id="position_div_id">
                    <label>Position</label>
                    <select class="form-control select " name="position_id" data-toggle="select2" readonly id="position_id">
                        <option value="">:::SELECT:::</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 py-2" id="staff_div_id">
                    <label>Staff Name</label>
                    <div class="state-section">
                        <select class="form-control select" name="staff_id" id="staff_id">
                            @foreach ($staff_data as $row)
                            <option value="{{ $row->id }}">{{ $row->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-2 col-md-2 py-4">
                    <label for="search">&nbsp;</label>
                    <button onclick="getPayrollOverview()" id="search" class="btn btn-primary btn-block"><span class="fa fa-search"></span></button>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="forms">
    <div class="card card_border py-2 mb-4">
        <div class="card-body col-lg-12">
            <div class="row form-group">
                <div class="col-lg-4 col-md-4  col-sm-12">
                    <fieldset class="form-group">
                        <legend class="text-success">Overview</legend>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex no-block">
                                <div class="me-3 align-self-center">
                                    <img src="/assets/expense-w.png" alt="Income" />
                                </div>
                                <div class="align-self-center">
                                    <h6 class="text-white mt-2 mb-0">Total Salary</h6>
                                    <h2 class="mt-0 text-white" id="total_salary">
                                        @if($total_salary)
                                        {{ $total_salary }}
                                        @else
                                        0.00
                                        @endif
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex no-block">
                                <div class="me-3 align-self-center">
                                    <img src="/assets/staff-w.png" alt="Income" />
                                </div>
                                <div class="align-self-center">
                                    <h6 class="text-white mt-2 mb-0">Active Staff</h6>
                                    <h2 class="mt-0 text-white" id="active_staff">
                                    @if($total_staff)
                                        {{ $total_staff }}
                                        @else
                                        0.00
                                        @endif
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<script>
    payroll_overview();
</script>

@endsection