@extends('layouts.adminlayout')

@section('title', config("app.name").' - Profile')

@section('content')

<main class="content">
    <div class="container-fluid p-0">

        <section class="section profile">

            <div class="row col-12 col-lg-12">
                <div class="col-12 col-lg-4">

                    <div class="tab">
                        <div class="tab-content">
                            <div class="tab-title"><a href="{{ route('admin.users') }}" style="text-decoration: none; font-size:large;"><i class="fas fa-chevron-left"></i> Back</a></div>

                            <h4 class="tab-title py-2">Profile Overview</h4>
                            <div class="align-items-center text-center" id="content">
                                @php
                                $photo = $user->photo;
                                $gender = $user->gender;
                                $avartar = ($gender == 'Male' || $gender == 'male' || $gender == 'MALE') ? 'avartar-m' : 'avartar-f';
                                $photo_path = ($photo != '' && file_exists($photo)) ? "/".$user->photo : "/assets/img/" . $avartar . '.png' @endphp
                                <img src="{{ $photo_path }}" alt="{{ $user->gender }}" class="img-fluid rounded-circle mb-2" width="128" height="128">
                                <h2>{{ $user->firstname . ' ' . $user->lastname }}</h2>
                                <h5>{{ $position_details->position_name }}</h5>
                                <h5>Last Login: {{ $last_access }}</h5>
                                <div class="social-links mt-2">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab">

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1" role="tabpanel">
                                <h4 class="tab-title">Login Days</h4>
                                <table class="table table-sm my-2">
                                    <tbody>
                                        <tr>
                                            <th>Sunday</th>
                                            <td>@if($user->day_1 == 1) <span class="badge bg-success">Allowed</span> @else <span class="badge bg-danger">Not Allowed</span> @endif</td>
                                        </tr>
                                        <tr>
                                            <th>Monday</th>
                                            <td>@if($user->day_2 == 1) <span class="badge bg-success">Allowed</span> @else <span class="badge bg-danger">Not Allowed</span> @endif</td>
                                        </tr>
                                        <tr>
                                            <th>Tuesday</th>
                                            <td>@if($user->day_3 == 1) <span class="badge bg-success">Allowed</span> @else <span class="badge bg-danger">Not Allowed</span> @endif</td>
                                        </tr>
                                        <tr>
                                            <th>Wednesday</th>
                                            <td>@if($user->day_4 == 1) <span class="badge bg-success">Allowed</span> @else <span class="badge bg-danger">Not Allowed</span> @endif</td>
                                        </tr>

                                        <tr>
                                            <th>Thursday</th>
                                            <td>@if($user->day_5 == 1) <span class="badge bg-success">Allowed</span> @else <span class="badge bg-danger">Not Allowed</span> @endif</td>
                                        </tr>
                                        <tr>
                                            <th>Friday</th>
                                            <td>@if($user->day_6 == 1) <span class="badge bg-success">Allowed</span> @else <span class="badge bg-danger">Not Allowed</span> @endif</td>
                                        </tr>
                                        <tr>
                                            <th>Saturday</th>
                                            <td>@if($user->day_7 == 1) <span class="badge bg-success">Allowed</span> @else <span class="badge bg-danger">Not Allowed</span> @endif</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">

                    <div class="tab">

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1" role="tabpanel">
                                <h4 class="tab-title">Profile Details</h4>
                                <table class="table table-sm my-2">
                                    <tbody>
                                        <tr>
                                            <th>Full Name</th>
                                            <td>
                                                {{ $user->firstname . ' ' . $user->lastname }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Staff ID</th>
                                            <td>{{ $user->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Role</th>
                                            <td>{{ $position_details->position_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>{{ $department_details->display_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <td>{{ ucfirst($user->gender)  }}</td>
                                        </tr>

                                        <tr>
                                            <th>Business</th>
                                            <td>{{ $business_details->business_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $user->mobile_phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>@if($user->user_disabled == 0)  <span class="badge bg-success">Active</span> @else <span class="badge bg-danger">Disabled</span> @endif </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </section>
    </div>
</main>

@endsection