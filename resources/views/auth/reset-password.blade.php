@extends('layouts.admin')
@section('content')
<main class="signup-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="container d-flex flex-column">
                <div class="row h-100">
                    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                        <div class="d-table-cell align-middle">

                            <div class="text-center mt-4">
                                <h1 class="h2">Welcome back</h1>
                                <p class="lead text-danger">
                                    Please change your password to continue
                                </p>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="m-sm-4">
                                        <div class="text-center">
                                            <img src="/assets/img/logo-removebg-preview.png" alt="Cantina Logo" class="img-fluid rounded-circle" width="132" height="132" />
                                        </div>
                                        <form method="POST" action="{{ route('password.update') }}">
                                            @csrf

                                            <input type="hidden" name="token" value="{{ $token }}">

                                            <div class="form-group row py-2">
                                                <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                                <div class="col-md-12">
                                                    <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                                    @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row py-2">
                                                <label for="password" class="col-md-12 col-form-label text-md-right">{{ __('Password') }}</label>
                                                <div class="col-md-12">
                                                    <div class="password-toggle">
                                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                                        <span id="visibility-icon" class="toggle-password" onclick="togglePasswordVisibility('password', 'visibility-icon')"> <i class="fas fa-eye"></i></span>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row py-2">
                                                <label for="password-confirm" class="col-md-12 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                                <div class="col-md-12">
                                                    <div class="password-toggle">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                        <span id="visibility-icon-1" class="toggle-password" onclick="togglePasswordVisibility('password-confirm', 'visibility-icon-1')"> <i class="fas fa-eye"></i></span>
                                                    </div>
                                                    @if ($errors->has('password_confirmation'))
                                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0 py-3">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Reset Password') }}
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
            </div>
        </div>
    </div>
</main>