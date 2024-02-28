@extends('layouts.adminlayout')
@section('title', config("app.name").' - Business Setup')
@section('content')

<div class="container" style="padding-top: 40px !important;">
    <div class="row justify-content-center">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('All Posts') }}</div>

                <div class="card-body">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <form action="javascript:void(0)" method="post">
                        @csrf
                        <div class="row mb-4">
                            <div id="bulkOptionContainer" class="col-lg-4">
                                <select name="bulk_options" class="form-control select" id="action">
                                    <option value="">::Select an Option::</option>
                                    <option value="published">Publish</option>
                                    <option value="draft">Draft</option>
                                    <option value="delete">Delete</option>
                                    <option value="reset_view_count">Reset Views Count</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <input type="hidden" name="post_id" value="" id="post_id">
                                <a style="color: white;" class="btn btn-success" onclick="applyAction()">Apply</a>
                                <a href="{{ route('blog.create') }}" class="btn btn-primary">Add New</a>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover allpost responsive">

                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th><label class="form-label"> All</label> <br><input type="checkbox" name="select_all" id="selectAllBoxes"></th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments Count</th>
                                    <th>Views Count</th>
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

@endsection