@extends('layouts.adminlayout')

@section('title', config("app.name").' - Payroll')

@section('content')

<div class="container-fluid py-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Payroll Update Form</h3>
            </div>
            <div class="card-body">
                <form id="form1" method="POST" class="simple-example" enctype="multipart/form-data" action="{{ route('payroll.setup-update', ['id' => $payroll->id]) }}" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <div class="form-group p-2">
                                <label for="" class="control-label">Date From :</label>
                                <input type="date" class="form-control" name="date_from" value="{{ $payroll->date_from }}">
                                @if($errors->has('date_from')) <span class="text-danger">{{ $errors->first('date_from') }}</span> @endif
                            </div>
                            <div class="form-group p-2">
                                <label for="" class="control-label">Date To :</label>
                                <input type="date" class="form-control" name="date_to" value="{{ $payroll->date_to }}">
                                @if($errors->has('date_to')) <span class="text-danger">{{ $errors->first('date_to') }}</span> @endif
                            </div>
                            <div class="form-group p-2">
                                <label for="" class="control-label">Payroll Type :</label>
                                <select name="payroll_type" class="form-control custom-select browser-default select" id="">
                                    <option value="" @if($payroll->payroll_type =='') selected @endif>:::SELECT:::</option>
                                    <option value="1" @if($payroll->payroll_type =='1') selected @endif>Monthly</option>
                                    <option value="2" @if($payroll->payroll_type =='2') selected @endif>Semi-Monthly</option>
                                </select>
                            </div>
                            @if($errors->has('payroll_type')) <span class="text-danger">{{ $errors->first('payroll_type') }}</span> @endif
                        </div>

                        <div class="col-lg-3"></div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary col-sm-3 offset-md-3" id="save_facility"> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>


</div>

@endsection