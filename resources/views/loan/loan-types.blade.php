@extends('layouts.adminlayout')

@section('title', config("app.name").' - Loans')

@section('content')

<div class="container-fluid  py-4">

    <div class="col-lg-12">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-4">
                <form id="form1" method="POST" class="simple-example" enctype="multipart/form-data" action="{{ route('loans.types.store') }}" novalidate>
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            Loan Types Form
                        </div>
                        <div class="card-body">
                            
                            <div class="form-group">&nbsp;
                                <label class="control-label">Loan type</label>
                                <input name="display_name" type="text" id="display_name" value="{{ old('display_name') }}" class="form-control" required>
                                @if($errors->has('display_name')) <span class="text-danger">{{ $errors->first('display_name') }}</span> @endif
                            </div>
                            <div class="form-group py-3">
                                <label class="control-label">Description</label>
                                <textarea name="description" id="" cols="30" rows="2" class="form-control" required>{{ old('description') }}</textarea>
                                @if($errors->has('description')) <span class="text-danger">{{ $errors->first('description') }}</span> @endif
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3" type="submit" id="save_facility"> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- FORM Panel -->

            <!-- Table Panel -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table id="loan-types-datatables" class="table table-striped " style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Display Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>

</div>
<style>
    td {
        vertical-align: middle !important;
    }

    td p {
        margin: unset
    }

    img {
        max-width: 100px;
        max-height: 150px;
    }
</style>

@endsection