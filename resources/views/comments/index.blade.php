@extends('layouts.adminlayout')
@section('title', config("app.name").' - Comments')
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
                                    <option value="approved">Approve</option>
                                    <option value="disapproved">Disapprove</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <input type="hidden" name="comment_id" value="" id="comment_id">
                                <a style="color: white;" class="btn btn-success" onclick="applyCommentAction()">Apply</a>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover allcomments responsive">

                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th><label class="form-label"> All</label> <br><input type="checkbox" name="select_all" id="selectAllComm"></th>
                                    <th>Author</th>
                                    <th>Content</th>
                                    <th>Email</th>
                                    <th>In Response To</th>
                                    <th>Status</th>
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