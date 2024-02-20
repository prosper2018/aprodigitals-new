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
                                    To get new activation mail, please enter your email to continue
                                </p>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="m-sm-4">
                                        <div class="text-center">
                                            <img src="/assets/img/logo-removebg-preview.png" alt="Cantina Logo" class="img-fluid rounded-circle" width="132" height="132" />
                                        </div>
                                        <form method="POST" action="{{ route('resend.activation.mail') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input class="form-control form-control-lg" type="text" name="email" placeholder="Enter email" />
                                                @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>

                                            <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-lg btn-primary">Submit Request</button><br />
                                                <small class="text-center col-lg-12 py-2 text-3 col-md-12 col-sm-12">
                                                    <a href="{{ route('login') }}">I have been verrified</a>
                                                </small>
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