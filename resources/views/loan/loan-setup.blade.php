@extends('layouts.adminlayout')

@section('title', config("app.name").' - Loans')

@section('content')

<div class="container-fluid py-4">

    <h1 class="h3 mb-3">Staff Deduction</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <!-- <h5 class="card-title mb-0">Empty card</h5> -->
                </div>
                <div class="card-body">
                    <div class="container-fluid p-0">

                        <div class="col-lg-12">
                            <div class="white_box mb_30">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12">

                                        <div class="modal-content cs_modal">

                                            <div class="modal-body">

                                                <form id="form1" method="POST" class="simple-example" enctype="multipart/form-data" action="{{ route('loans.setup') }}" novalidate>
                                                    @csrf

                                                    <div class="row">
                                                        <div class="p-1 mb-4 col-lg-6">
                                                            <label class="form-label">
                                                                Department
                                                            </label>
                                                            <select name="department_id" id="department_id" class="form-control select" onchange="getStaffByDept(this.value)">
                                                                <option value="">::Select Department::</option>
                                                                @foreach ($departments as $key => $department)
                                                                <option value="{{ $department->id }}" @if(old('department_id')==strval($department->id)) selected @endif>{{ $department->display_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('department_id'))
                                                            <span class="text-danger font-weight-bold" role="alert">
                                                                {{ $errors->first('department_id') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div class="p-1 mb-4 col-lg-6">
                                                            <label class="form-label">
                                                                Staff Name
                                                            </label>
                                                            <select class="form-control select" name="staff_id" disabled id="staff_id">
                                                                <option value="">:::SELECT DEPARTMENT FIRST:::</option>
                                                            </select>
                                                            @if ($errors->has('staff_id'))
                                                            <span class="text-danger font-weight-bold" role="alert">
                                                                {{ $errors->first('staff_id') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div class="p-1 mb-4 col-lg-6">
                                                            <label class="form-label">
                                                                Loan Type
                                                            </label>
                                                            <select class="form-control select" name="loan_type">
                                                                <option value="">:::SELECT:::</option>
                                                                @foreach ($loan_type as $row)
                                                                <option value="{{ $row->id }}" @if(old('loan_type')==strval($row->id)) selected @endif>{{ $row->display_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('loan_type'))
                                                            <span class="text-danger font-weight-bold" role="alert">
                                                                {{ $errors->first('loan_type') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div class="p-1 mb-4 col-lg-6">
                                                            <label class="form-label">
                                                                Repayment Frequency
                                                            </label>
                                                            <select class="form-control select" name="repayment_type" onchange="toggleform(this.value)" id="repayment_type">
                                                                <option value="">:::SELECT:::</option>
                                                                <option value="1" @if(old('repayment_type')==1) selected @endif>Monthly</option>
                                                                <option value="2" @if(old('repayment_type')==2) selected @endif>Semi-Monthly</option>
                                                                <option value="3" @if(old('repayment_type')==3) selected @endif>Once</option>
                                                            </select>
                                                            @if ($errors->has('repayment_type'))
                                                            <span class="text-danger font-weight-bold" role="alert">
                                                                {{ $errors->first('repayment_type') }}
                                                            </span>
                                                            @endif
                                                        </div>

                                                        <div class="p-1 mb-2 col-lg-6" id="number_of_repayments_id">
                                                            <label class="form-label">
                                                                Number of Repayments
                                                            </label>
                                                            <input class="form-control" type="number" name="number_of_repayments" value="{{ old('number_of_repayments') }}" />
                                                            @if ($errors->has('number_of_repayments'))
                                                            <span class="text-danger font-weight-bold" role="alert">
                                                                {{ $errors->first('number_of_repayments') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div class="p-1 mb-2 col-lg-6 number_of_repayments_id" id="number_of_days_id" style="display:none">
                                                            <label class="form-label">
                                                                Number of Days
                                                            </label>
                                                            <input class="form-control" type="number" name="number_of_days" value="{{ old('number_of_days') }}" />
                                                            @if ($errors->has('number_of_days'))
                                                            <span class="text-danger font-weight-bold" role="alert">
                                                                {{ $errors->first('number_of_days') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div class="p-1 mb-2 col-lg-6">
                                                            <label class="form-label">
                                                                Repayment Start Date
                                                            </label>
                                                            <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}" />
                                                            @if ($errors->has('start_date'))
                                                            <span class="text-danger font-weight-bold" role="alert">
                                                                {{ $errors->first('start_date') }}
                                                            </span>
                                                            @endif
                                                        </div>

                                                        <div class="p-1 mb-2 col-lg-6">
                                                            <label class="form-label">
                                                                Loan Amount
                                                            </label>
                                                            <input class="form-control" type="number" name="amount" value="{{ old('amount') }}" />
                                                            @if ($errors->has('amount'))
                                                            <span class="text-danger font-weight-bold" role="alert">
                                                                {{ $errors->first('amount') }}
                                                            </span>
                                                            @endif
                                                        </div>

                                                        <div class="p-1 mb-2 col-lg-6">
                                                            <label class="form-label">Reason</label>
                                                            <div class="form-group form-default">
                                                                <textarea class="form-control" name="reason">{{ old('reason') }}</textarea>
                                                                <span class="form-bar"></span>
                                                                @if ($errors->has('reason'))
                                                                <span class="text-danger font-weight-bold" role="alert">
                                                                    {{ $errors->first('reason') }}
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="p-1 mb-2 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Currency Type</label><br><br>
                                                                <input type="hidden" name="currency_type" id="currency_type" value="" />
                                                                <label class="switch">
                                                                    <input type="checkbox" id="toggleButton" />
                                                                    <span class="slider"></span>
                                                                    <span class="on">NAIRA</span>
                                                                    <span class="off">USD</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="server_mssg"></div>
                                                    <div class="row text-center py-4">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-lg btn-primary col-sm-3 offset-md-3" id="save_facility"> Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection