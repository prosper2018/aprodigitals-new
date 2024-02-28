@extends('layouts.adminlayout')
@section('title', config("app.name").' - Businesses')
@section('content')
<style>
    .filter_container {
        background-color: #e8e8ff;
        border-radius: 8px;
        padding: 20px;
        margin-top: 30px;
    }

    .row {
        margin-bottom: 20px;
    }

    .filter-input {
        height: 40px;
        background-color: white;
        border: 2px solid white;
    }

    .filter-btn {
        background-color: #80CECA;
        color: white;
        border: 3px solid #80CECA;
        border-radius: 50px;
        padding: 8px 31px;
    }

    @media (max-width: 767px) {

        .filter-input,
        .filter-btn {
            width: 100%;
        }
    }
</style>

<div class="container" style="padding-top: 40px !important;">
    <div class="filter_container mb-4">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h1 class="job-heading">Filters</h1>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-3">
                <input class="filter-input" id="business_name" placeholder="Search by name" name="business_name" value="">
            </div>
            <div class="col-md-3">
                <select class="filter-input" name="job_country" id="location">
                    <option value="">Filter by country</option>
                    <option value="1077">afghai</option>
                    <option value="3">Afghanistan</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="filter-input" name="status" id="status">
                    <option value="">Filter by status</option>
                    <option value="all">ALL</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="filter-btn" id="apply_business_filter">Search</button>
            </div>
        </div>
    </div>


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

@endsection