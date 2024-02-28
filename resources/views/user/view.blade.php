@extends('layouts.adminlayout')
@section('title', config("app.name").' - User View')
@section('content')


<div class="container" style="padding-top: 40px !important;">
    <div class="row justify-content-center">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('All Users') }}</div>

                <div class="card-body">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <form action="javascript:void(0)" method="post">
                        @csrf
                        <div class="row mb-4">

                            <div class="col-lg-4">
                                <input type="hidden" name="post_id" value="" id="post_id">
                                <a href="/user" class="btn btn-primary">Add New</a>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover allusers responsive">

                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone Number</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Password Missed Count</th>
                                    <th>Login Status</th>
                                    <th>Action</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>

                        </table>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection