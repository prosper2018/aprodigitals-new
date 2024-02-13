@extends('layouts.admin')
@section('content')

<div class="wrapper">
    @include('layouts.partials.sidebar')
    <div class="main">

        @include('layouts.partials.top_menubar')
        <div class="container" style="padding-top: 40px !important;">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-bold">All Registered Businesses</h1>
                    <div class="float-end"><a href="{{ route('business.form') }}" class="btn btn-info">Add Business</a></div>
                </div>
                <div class="card-body">

                    <table id="all-businesses" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">S/N</th>
                                <th scope="col">Business</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Address</th>
                                <th scope="col">Description</th>
                                <th scope="col">Total Staff</th>
                                <th scope="col">Active Staff</th>
                                <th scope="col">Total Salary</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                        <!-- <tfoot>

                        </tfoot> -->
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>