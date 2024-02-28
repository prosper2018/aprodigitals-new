@extends('layouts.adminlayout')
@section('title', config("app.name").' - User Setup')
@section('content')

<style>
    #login_days>label {
        margin-right: 50px;
    }
</style>

<div class="container" style="padding-top: 40px !important;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Register') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="col-form-label">{{ __('User Name') }}</label>

                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" autocomplete="username" autofocus>

                                @if ($errors->has('username'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('username') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="col-form-label">{{ __('First Name') }}</label>

                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" autocomplete="firstname" autofocus>

                                @if ($errors->has('firstname'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('firstname') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="col-form-label">{{ __('Last Name') }}</label>

                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" autocomplete="lastname" autofocus>

                                @if ($errors->has('lastname'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('lastname') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mobile_phone" class="col-form-label">{{ __('Phone Number') }}</label>

                                <input id="mobile_phone" type="text" class="form-control" name="mobile_phone" value="{{ old('mobile_phone') }}" autocomplete="mobile_phone" autofocus>

                                @if ($errors->has('mobile_phone'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('mobile_phone') }}
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="col-form-label">{{ __('Email Address') }}</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autocomplete="email">

                                @if ($errors->has('email'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="department_id" class="col-form-label">{{ __('Department') }}</label>

                                <select name="department_id" id="department_id" class="form-control select" onchange="updateRoleOptions()">
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
                            <div class="col-md-6 mb-3">
                                <label for="position_id" class="col-form-label">{{ __('User Role') }}</label>

                                <select name="position_id" id="position_id" class="form-control select">
                                    <option value="">::Select Position::</option>
                                </select>
                                @if ($errors->has('position_id'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('position_id') }}
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="col-form-label">{{ __('Gender') }}</label>

                                <select class="form-control select" name="gender" id="gender">
                                    <option value="">::select option::</option>
                                    <option value="Male" @if(old('gender')=='Male' ) selected @endif>Male</option>
                                    <option value="Female" @if(old('gender')=='Female' ) selected @endif>Female</option>
                                </select>
                                @if ($errors->has('gender'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('gender') }}
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="col-form-label">{{ __('Password') }}</label>
                                <div class="password-toggle">
                                    <input id="password" type="password" value="{{ old('password') }}" class="form-control" name="password" autocomplete="new-password">

                                    <span id="visibility-icon" class="toggle-password" onclick="togglePasswordVisibility('password', 'visibility-icon')"> <i class="fas fa-eye"></i></span>
                                </div>
                                @if ($errors->has('password'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('password') }}
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob" class="col-form-label">{{ __('Date of Birth') }}</label>

                                <input id="dob" type="date" class="form-control" name="dob" value="{{ old('dob') }}" autocomplete="dob">
                                @if ($errors->has('dob'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('dob') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" role="2" name="contact_address" style="height: 80px !important;" id="contact_address">{{ old('contact_address') }}</textarea>
                                    @if ($errors->has('contact_address'))
                                    <span class="text-danger font-weight-bold" role="alert">
                                        {{ $errors->first('contact_address') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Nationality</label>

                                    <select class="form-control select " name="nationality" data-toggle="select2" id="nationality">
                                        <option value="">:::SELECT:::</option>
                                        @foreach ($country_codes as $row)
                                        <option value="{{ $row->id }}" @if(old('nationality')==strval($row->id)) selected @endif>{{ $row->country_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('nationality'))
                                    <span class="text-danger font-weight-bold" role="alert">
                                        {{ $errors->first('nationality') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Religion</label>
                                    <select class="form-control select " name="religion" data-toggle="select2" id="religion">
                                        <option value="">:::SELECT:::</option>
                                        @foreach ($religions as $row)
                                        <option value="{{ $row->id }}" @if(old('religion')==strval($row->id)) selected @endif>{{ $row->display_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('religion'))
                                    <span class="text-danger font-weight-bold" role="alert">
                                        {{ $errors->first('religion') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Martital Status</label>
                                    <select class="form-control select " name="marital_status" data-toggle="select2" id="marital_status">
                                        <option value="">:::SELECT:::</option>
                                        <option value="Single" @if(old('marital_status')=='Single' ) selected @endif>Single</option>
                                        <option value="Married" @if(old('marital_status')=='Married' ) selected @endif>Married</option>
                                        <option value="Divorced" @if(old('marital_status')=='Divorced' ) selected @endif>Divorced</option>
                                        <option value="Widowed" @if(old('marital_status')=='Widowed' ) selected @endif>Widowed</option>
                                    </select>
                                    @if ($errors->has('marital_status'))
                                    <span class="text-danger font-weight-bold" role="alert">
                                        {{ $errors->first('marital_status') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Employment Date</label>
                                    <input class="form-control date-picker" name="employment_date" value="{{ old('employment_date') }}" placeholder="Select Date" type="date" id="employment_date" />
                                </div>
                                @if ($errors->has('employment_date'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('employment_date') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Termination Date</label>
                                    <input class="form-control date-picker" name="termination_date" value="{{ old('termination_date') }}" placeholder="Select Date" type="date" id="termination_date" />
                                </div>
                                @if ($errors->has('termination_date'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('termination_date') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Employment Type</label>
                                    <select class="form-control select " name="employment_type" data-toggle="select2" id="employment_type">
                                        <option value="">:::SELECT:::</option>
                                        <option value="Full Time" @if(old('employment_date')=='Full Time' ) selected @endif>Full Time</option>
                                        <option value="Part Time" @if(old('employment_date')=='Part Time' ) selected @endif>Part Time</option>
                                        <option value="Contract" @if(old('employment_date')=='Contract' ) selected @endif>Contract</option>
                                    </select>
                                    @if ($errors->has('employment_type'))
                                    <span class="text-danger font-weight-bold" role="alert">
                                        {{ $errors->first('employment_type') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Business Entity</label>
                                    <select class="form-control select" name="business_id" data-toggle="select2" id="business_id">
                                        <option value="">:::SELECT:::</option>
                                        @foreach ($businesses as $row)
                                        <option value="{{ $row->id }}" @if(old('business_id')==strval($row->id)) selected @endif>{{ $row->business_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('business_id'))
                                    <span class="text-danger font-weight-bold" role="alert">
                                        {{ $errors->first('business_id') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Entry Salary</label>
                                    <input type="number" class="form-control" name="entry_salary" value="{{ old('entry_salary') }}" placeholder="Entry Salary" autocomplete="off" id="entry_salary">
                                </div>
                                @if ($errors->has('entry_salary'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('entry_salary') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Current Salary(NAIRA)</label>
                                    <input type="number" class="form-control" name="current_salary" value="{{ old('current_salary') }}" placeholder="Current Salary(NAIRA)" autocomplete="off" id="current_salary">
                                </div>
                                @if ($errors->has('current_salary'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('current_salary') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Current Salary(USD)</label>
                                    <input type="number" class="form-control" name="current_usd_salary" value="{{ old('current_usd_salary') }}" placeholder="Current Salary(USD)" autocomplete="off" id="current_usd_salary">
                                </div>
                                @if ($errors->has('current_usd_salary'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('current_usd_salary') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Last Increment</label>
                                    <input type="number" class="form-control" name="last_increment" value="{{ old('last_increment') }}" placeholder="Last Increment" autocomplete="off" id="last_increment">
                                </div>
                                @if ($errors->has('last_increment'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('last_increment') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Last Increment Date</label>
                                    <input type="date" class="form-control date-picker" name="last_increment_date" value="{{ old('last_increment_date') }}" placeholder="Last Increment Date" autocomplete="off" id="last_increment_date">
                                </div>
                                @if ($errors->has('last_increment_date'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('last_increment_date') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Last Promotion Date</label>
                                    <input class="form-control date-picker" name="last_promotion" value="{{ old('last_promotion') }}" placeholder="Select Date" type="date" id="last_promotion" />
                                </div>
                                @if ($errors->has('last_promotion'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('last_promotion') }}
                                </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-sm-12 mb-3">
                                <label class="form-label">Staff Passport</label>
                                <input type="file" name="photo" class="form-control" id="photo" onchange="handleFileInput('photo', 'preview');">
                                <img src="" id="preview" alt="Passport Preview" width="100px" height="100px" style="display: none;">
                                @if ($errors->has('photo'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('photo') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <label class="form-label">Staff ID</label>
                                <input type="file" name="staff_id_card" class="form-control" id="staff_id_card" onchange="handleFileInput('staff_id_card', 'preview-2');">
                                <img src="" id="preview-2" alt="ID Preview" width="100px" height="100px" style="display: none;">
                                @if ($errors->has('staff_id_card'))
                                <span class="text-danger font-weight-bold" role="alert">
                                    {{ $errors->first('staff_id_card') }}
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
                                        <label class="form-label">Account Number</label>
                                        <input type="number" class="form-control" name="bank_account_no" value="{{ old('bank_account_no') }}" placeholder="Account Number" autocomplete="off" id="bank_account_no">
                                    </div>
                                    @if ($errors->has('bank_account_no'))
                                    <span class="text-danger font-weight-bold" role="alert">
                                        {{ $errors->first('bank_account_no') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-sm-12 p-3">
                                    <div class="form-group">
                                        <label class="form-label">Bank Name</label>
                                        <select class="form-control select" name="bank_code" id="bank_code" onchange="getBankAccount()" data-toggle="select2">
                                            <option value="">:::SELECT:::</option>
                                            @foreach ($banks as $row)

                                            <option value="{{ $row->bank_code }}" @if(old('bank_code')==strval($row->id) || old('bank_code') == strval($row->bank_code)) selected @endif>{{ $row->bank_name }}</option>

                                            @endforeach
                                        </select>
                                        @if ($errors->has('bank_code'))
                                        <span class="text-danger font-weight-bold" role="alert">
                                            {{ $errors->first('bank_code') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12 p-3">
                                    <div class="form-group">
                                        <label class="form-label">Account Name <i class="fa fa-spinner fa-spin" id="spinner" style="display: none;"></i></label>
                                        <input type="text" class="form-control" name="bank_account_name" onblur="getBankAccount()" value="{{ old('bank_account_name') }}" placeholder="Account Name" id="bank_account_name" autocomplete="off" readonly>
                                    </div>
                                    @if ($errors->has('bank_account_name'))
                                    <span class="text-danger font-weight-bold" role="alert">
                                        {{ $errors->first('bank_account_name') }}
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

@endsection