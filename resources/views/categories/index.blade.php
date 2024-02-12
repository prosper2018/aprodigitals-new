@extends('layouts.admin')
@section('content')
<div class="wrapper">
    @include('layouts.partials.sidebar')
    <div class="main">

        @include('layouts.partials.top_menubar')
        <div id="container" style="padding-top: 40px !important;">

            <div class="row justify-content-center">

                <div class="row">

                    <h1 class="page-header">
                        Manage Categories
                        <small>ROLE NAME</small>
                    </h1>
                    <hr style="margin-bottom: 30px !important;">

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- Add New Category form -->
                                <form action="{{ route('categories.store') }}" method="post">
                                    @csrf
                                    <div class="form-group mb-4">
                                        <label for="cat_title">Add New Category</label>
                                        <input type="text" class="form-control" name="cat_title" placeholder="Category Title">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" name="btn_add" value="Add Category">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="py-3"></div>
                                @if (session('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('message') }}
                                </div>
                                @elseif(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                                @endif

                                <form action="javascript:void(0)" method="post">
                                    @csrf
                                    <div class="row mb-4">

                                        <div class="col-lg-4">
                                            <input type="hidden" name="cat_id" value="" id="cat_id">
                                            <a style="color: white;" class="btn btn-danger" onclick="delete_multi_category()">DELETE</a>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-hover allcategories responsive">
                                        <!-- Display All Categories Table -->
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th><label class="form-label"> All</label> <br><input type="checkbox" name="select_all" id="selectAllCat"></th>
                                                <th>Category Title</th>
                                                <th>Date</th>
                                                <th>Operations</th>
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
        </div>
    </div>
</div>
@endsection