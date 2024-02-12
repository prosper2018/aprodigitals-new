@extends('layouts.admin')
@section('content')
<div class="wrapper">
    @include('layouts.partials.sidebar')
    <div class="main">

        @include('layouts.partials.top_menubar')
        <div class="container" style="padding-top: 40px !important;">
            <div class="row justify-content-center">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">{{ __('All Positions') }}</div>

                        <div class="card-body">
                            @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                            @endif

                            <form action="javascript:void(0)" method="post">
                                @csrf

                                <table class="table table-bordered table-hover allpositions responsive">

                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Position</th>
                                            <th>Department</th>
                                            <th>Status</th>
                                            <th>Enabled ?</th>
                                            <th>Requires Login ?</th>
                                            <th>Added By</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $sno = 1;
                                        @endphp
                                        @foreach($positions as $position)
                                        <tr>
                                            <td>{{ $sno++ }}</td>
                                            <td>{{ $position->position_name }}</td>
                                            <td>{{ $position->department_id }}</td>
                                            <td>{{ $position->is_deleted }}</td>
                                            <td>{{ ($position->position_enabled == 1) ? 'Yes' : 'No' }}</td>
                                            <td>{{ ($position->requires_login == 1) ? 'Yes' : 'No' }}</td>
                                            <td>{{ $position->posted_user }}</td>
                                            <td>{{ $position->created_at }}</td>
                                            <td>{{ $position->id }}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                                {{ $positions->links('pagination::bootstrap-4') }} <!-- Display pagination links -->
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection