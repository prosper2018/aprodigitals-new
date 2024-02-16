@extends('layouts.admin')
@section('content')

<style>
    #login_days>label {
        margin-right: 50px;
    }
</style>

<div class="wrapper">
    @include('layouts.partials.sidebar')
    <div class="main">

        @include('layouts.partials.top_menubar')
        <div class="container" style="padding-top: 40px !important;">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Register') }}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.store') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="col-form-label">{{ __('User Name') }}</label>

                                        <input id="username" type="text" class="form-control" name="username" value="" autocomplete="username" autofocus>

                                        @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="firstname" class="col-form-label">{{ __('First Name') }}</label>

                                        <input id="firstname" type="text" class="form-control" name="firstname" value="" autocomplete="firstname" autofocus>

                                        @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="col-form-label">{{ __('Last Name') }}</label>

                                        <input id="lastname" type="text" class="form-control" name="lastname" value="" autocomplete="lastname" autofocus>

                                        @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="mobile_phone" class="col-form-label">{{ __('Phone Number') }}</label>

                                        <input id="mobile_phone" type="text" class="form-control" name="mobile_phone" value="" autocomplete="mobile_phone" autofocus>

                                        @if ($errors->has('mobile_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mobile_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="col-form-label">{{ __('Email Address') }}</label>

                                        <input id="email" type="email" class="form-control" name="email" value="" autocomplete="email">

                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="department_id" class="col-form-label">{{ __('Department') }}</label>

                                        <select name="department_id" id="department_id" class="form-control select" onchange="updateRoleOptions()">
                                            <option value="">::Select Department::</option>
                                            @foreach ($departments as $key => $department)
                                            <option value="{{ $department->id }}">{{ $department->display_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('department_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="position_id" class="col-form-label">{{ __('User Role') }}</label>

                                        <select name="position_id" id="position_id" class="form-control select">
                                            <option value="">::Select Position::</option>
                                        </select>
                                        @if ($errors->has('position_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('position_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="gender" class="col-form-label">{{ __('Gender') }}</label>

                                        <select class="form-control select" name="gender" id="gender">
                                            <option value="">::select option::</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        @if ($errors->has('gender'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="col-form-label">{{ __('Password') }}</label>
                                        <div class="password-toggle">
                                            <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">

                                            <span id="visibility-icon" class="toggle-password" onclick="togglePasswordVisibility('password', 'visibility-icon')"> <i class="fas fa-eye"></i></span>
                                        </div>
                                        @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="dob" class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>

                                        <input id="dob" type="date" class="form-control" name="dob" autocomplete="dob">
                                        @if ($errors->has('dob'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('dob') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" role="2" name="contact_address" style="height: 80px !important;" id="contact_address"></textarea>
                                            @if ($errors->has('contact_address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact_address') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Nationality</label>

                                            <select class="form-control select " name="nationality" data-toggle="select2" id="nationality">
                                                <option value="">:::SELECT:::</option>
                                                @foreach ($country_codes as $row)
                                                <option value="{{ $row->id }}">{{ $row->country_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('nationality'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nationality') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Religion</label>
                                            <select class="form-control select " name="religion" data-toggle="select2" id="religion">
                                                <option value="">:::SELECT:::</option>
                                                @foreach ($religions as $row)
                                                <option value="{{ $row->id }}">{{ $row->display_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('religion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('religion') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Martital Status</label>
                                            <select class="form-control select " name="marital_status" data-toggle="select2" id="marital_status">
                                                <option value="">:::SELECT:::</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Divorced">Divorced</option>
                                                <option value="Widowed">Widowed</option>
                                            </select>
                                            @if ($errors->has('marital_status'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('marital_status') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Employment Date</label>
                                            <input class="form-control date-picker" name="employment_date" value="" placeholder="Select Date" type="date" id="employment_date" />
                                        </div>
                                        @if ($errors->has('employment_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('employment_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Termination Date</label>
                                            <input class="form-control date-picker" name="termination_date" value="" placeholder="Select Date" type="date" id="termination_date" />
                                        </div>
                                        @if ($errors->has('termination_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('termination_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Employment Type</label>
                                            <select class="form-control select " name="employment_type" data-toggle="select2" id="employment_type">
                                                <option value="">:::SELECT:::</option>
                                                <option value="Full Time">Full Time</option>
                                                <option value="Part Time">Part Time</option>
                                                <option value="Contract">Contract</option>
                                            </select>
                                            @if ($errors->has('employment_type'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('employment_type') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Business Entity</label>
                                            <select class="form-control select" name="business_id" data-toggle="select2" id="business_id">
                                                <option value="">:::SELECT:::</option>
                                                @foreach ($businesses as $row)
                                                <option value="{{ $row->id }}">{{ $row->business_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('business_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('business_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Entry Salary</label>
                                            <input type="number" class="form-control" name="entry_salary" value="" placeholder="Entry Salary" autocomplete="off" id="entry_salary">
                                        </div>
                                        @if ($errors->has('entry_salary'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('entry_salary') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Current Salary(NAIRA)</label>
                                            <input type="number" class="form-control" name="current_salary" value="" placeholder="Current Salary(NAIRA)" autocomplete="off" id="current_salary">
                                        </div>
                                        @if ($errors->has('current_salary'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('current_salary') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Current Salary(USD)</label>
                                            <input type="number" class="form-control" name="current_usd_salary" value="" placeholder="Current Salary(USD)" autocomplete="off" id="current_usd_salary">
                                        </div>
                                        @if ($errors->has('current_usd_salary'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('current_usd_salary') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Last Increment</label>
                                            <input type="number" class="form-control" name="last_increment" value="" placeholder="Last Increment" autocomplete="off" id="last_increment">
                                        </div>
                                        @if ($errors->has('last_increment'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_increment') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Last Increment Date</label>
                                            <input type="date" class="form-control date-picker" name="last_increment_date" value="" placeholder="Last Increment Date" autocomplete="off" id="last_increment_date">
                                        </div>
                                        @if ($errors->has('last_increment_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_increment_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label>Last Promotion Date</label>
                                            <input class="form-control date-picker" name="last_promotion" value="" placeholder="Select Date" type="date" id="last_promotion" />
                                        </div>
                                        @if ($errors->has('last_promotion'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_promotion') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-4 col-sm-12 mb-3">
                                        <label class="form-label">Staff Passport</label>
                                        <input type="file" name="photo" id="photo" onchange="handleFileInput('photo', 'preview');">
                                        <img src="" id="preview" alt="Passport Preview" width="100px" height="100px" style="display: none;">
                                        @if ($errors->has('photo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('photo') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12 p-3">
                                        <label class="form-label">Staff ID</label>
                                        <input type="file" name="staff_id_card" id="staff_id_card" onchange="handleFileInput('staff_id_card', 'preview-2');">
                                        <img src="" id="preview-2" alt="ID Preview" width="100px" height="100px" style="display: none;">
                                        @if ($errors->has('staff_id_card'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('staff_id_card') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 py-4">
                                    <h4 for=""><b>Bank Account Details</b></h4>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 pb-0" id="login_days">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 p-3">
                                            <div class="form-group">
                                                <label>Account Number</label>
                                                <input type="number" class="form-control" name="bank_account_no" value="" placeholder="Account Number" autocomplete="off" id="bank_account_no">
                                            </div>
                                            @if ($errors->has('bank_account_no'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('bank_account_no') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-4 col-sm-12 p-3">
                                            <div class="form-group">
                                                <label>Bank Name</label>
                                                <select class="form-control select" name="bank_code" id="bank_code" onchange="getBankAccount()" data-toggle="select2">
                                                    <option value="">:::SELECT:::</option>
                                                    @foreach ($banks as $row)
                                                    <option value="{{ $row->bank_code }}">{{ $row->bank_name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('bank_code'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bank_code') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 p-3">
                                            <div class="form-group">
                                                <label>Account Name <i class="fa fa-spinner fa-spin" id="spinner" style="display: none;"></i></label>
                                                <input type="text" class="form-control" name="bank_account_name" onblur="getBankAccount()" value="" placeholder="Account Name" id="bank_account_name" autocomplete="off" readonly>
                                            </div>
                                            @if ($errors->has('bank_account_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('bank_account_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 py-2">
                                            <h4 for=""><b>Login Days</b></h4>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 pb-0" id="login_days">
                                            <label class="form-label" id="day1"><input type="checkbox" value="1" name="day_1" checked> Sunday</label>
                                            <label class="form-label" id="day2"><input type="checkbox" value="1" name="day_2" checked> Monday</label>
                                            <label class="form-label" id="day3"><input type="checkbox" value="1" name="day_3" checked> Tuesday</label>
                                            <label class="form-label" id="day4"><input type="checkbox" value="1" name="day_4" checked> Wednesday</label>
                                            <label class="form-label" id="day5"><input type="checkbox" value="1" name="day_5" checked> Thursday</label>
                                            <label class="form-label" id="day6"><input type="checkbox" value="1" name="day_6" checked> Friday</label>
                                            <label class="form-label" id="day7"><input type="checkbox" value="1" name="day_7" checked> Saturday</label>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 py-3">
                                            <h4 for=""><b>Security Settings</b></h4>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label class="form-label" id="user_disabled"><input type="checkbox" value="1" name="user_disabled" id="day1"> Disable User</label><br>
                                            <label class="form-label" id="user_locked"><input type="checkbox" value="1" name="user_locked" id="day1"> Lock User</label><br>
                                            <label class="form-label" id="passchg_logon"><input type="checkbox" value="1" name="passchg_logon" checked id="passchg_logon"> Change password on first login</label>
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @endsection