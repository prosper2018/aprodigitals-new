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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Register') }}
                            @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.store') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('User Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

                                        @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                        @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="mobile_phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                                    <div class="col-md-6">
                                        <input id="mobile_phone" type="text" class="form-control @error('mobile_phone') is-invalid @enderror" name="mobile_phone" value="{{ old('mobile_phone') }}" required autocomplete="mobile_phone" autofocus>

                                        @error('mobile_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="position_id" class="col-md-4 col-form-label text-md-end">{{ __('User Role') }}</label>

                                    <div class="col-md-6">
                                        <select name="position_id" class="form-control select @error('position_id') is-invalid @enderror" required>
                                            <option>::Select Role::</option>
                                            @foreach ($positions as $key => $role)
                                            <option value="{{ $role->position_id }}">{{ $role->position_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('position_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control select  @error('gender') is-invalid @enderror" name="gender" id="gender">
                                            <option value="">::select option::</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 py-2">
                                    <h4 for=""><b>Login Days</b></h4>
                                    <!-- </div> -->
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