@extends('layouts.adminlayout')
@section('title', config("app.name").' - Business Edit')
@section('content')

<div class="container" style="padding-top: 40px !important;">
    <style>
        .hide {
            display: none;
        }
    </style>
    <style>
        #login_days>label {
            margin-right: 10px;
        }

        #security_block>label {
            margin-right: 10px;
        }

        .parent {
            height: 400px;
            width: 400px;
            position: relative;
        }

        .child {
            width: 70px;
            height: 70px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -35px 0 0 -35px;
        }
    </style>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">

                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Business Edit</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('businesses.update', ['id' => $business->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12 p-3">
                                    <label class="form-label">
                                        Business Name
                                    </label>
                                    <input type="text" class="form-control" id="business_name" name="business_name" value="{{ $business->business_name }}" placeholder="Business Name" autocomplete="off">
                                    @if($errors->has('business_name')) <span class="text-danger">{{ $errors->first('business_name') }}</span> @endif
                                </div>
                                <div class="form-group col-md-6 col-sm-12 p-3">
                                    <label class="form-label">Business Address</label>
                                    <textarea class="form-control" id="address" name="address">{{ $business->address }}</textarea>
                                    @if($errors->has('address')) <span class="text-danger">{{ $errors->first('address') }}</span> @endif
                                </div>
                                <div class="form-group col-md-6 col-sm-12 p-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description">{{ $business->description }}</textarea>
                                    @if($errors->has('description')) <span class="text-danger">{{ $errors->first('description') }}</span> @endif
                                </div>
                                <div class="form-group col-md-6 col-sm-12 p-3">
                                    <label class="form-label">Business Logo</label>
                                    <input type="file" name="logo" id="logo" onchange="handleFileInput('logo', 'preview');">
                                    <img src="{{ $business->logo }}" id="preview" alt="Logo Preview" width="100px" height="100px" style="display: none;">
                                    @if($errors->has('logo')) <span class="text-danger">{{ $errors->first('logo') }}</span> @endif
                                </div>

                                <div id="server_mssg"></div>
                                <div class="col-lg-12 text-center py-4">
                                    <div class="col-lg-4">
                                        <button class="btn btn-primary col-12" style="background-color: #000000;" id="save_facility"> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


@endsection