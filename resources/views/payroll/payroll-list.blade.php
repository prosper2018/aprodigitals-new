@extends('layouts.adminlayout')

@section('title', config("app.name").' - Payroll')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Payroll List</h5>
        <h6 class="card-subtitle text-muted">This record contains payrolls that has been setup in the system.</h6>
        <a class="btn btn-info mb-3 float-end" href="{{ route('payroll.setup-form') }}">Add Payroll</a>
    </div>
    <div class="card-body">

        <div id="datatables-basic_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table id="payroll-list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ref No</th>
                                <th>Payroll Type</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection