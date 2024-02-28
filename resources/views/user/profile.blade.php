@extends('layouts.mainlayout')

@section('title', config("app.name").' - Profile')

@section('content')

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Profile</h1>

        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Details</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="/assets/img/avatars/avatar-4.jpg" alt="Stacie Hall" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                        <h5 class="card-title mb-0">{{ auth()->user()->firstname." ".auth()->user()->lastname }}</h5>
                        <div class="text-muted mb-2">{{ $users->position_name }}</div>
                    </div>
                    <hr class="my-0" />

                </div>
            </div>

            <div class="col-md-8 col-xl-9">
                <!-- <div class="card"> -->
                <!-- <div class="col-12 col-lg-6"> -->
                <div class="tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab">Edit Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tab-3" data-bs-toggle="tab" role="tab">Change Password</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-1" role="tabpanel">
                            <h4 class="tab-title">Details</h4>
                            <table class="table table-sm my-2">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $users->firstname." ".$users->lastname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>{{$users->position_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $users->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $users->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $users->mobile_phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>@switch($users->user_disabled)
                                            @case(1)
                                            <span class="badge bg-danger">Disabled</span>
                                            @break

                                            @case(0)
                                            <span class="badge bg-success">Active</span>
                                            @break

                                            @default
                                            <span class="badge bg-danger">Undefined</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-2" role="tabpanel">
                            <h4 class="tab-title">Profile Update</h4>

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
                                    <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control select @error('gender') is-invalid @enderror" name="gender" id="gender">
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
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="tab-3" role="tabpanel">
                            <h4 class="tab-title">One more</h4>
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>

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
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>

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
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Change') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</main>

@endsection