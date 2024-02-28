@extends('layouts.adminlayout')
@section('title', config("app.name").' - User Upload')
@section('content')

<div class="container" style="padding-top: 40px !important;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Staff Bulk Upload') }}

                    <div class="btn-group float-end">
                        <a type="button" title="Staff Bulk Upload Template Download" class="btn btn-success" href="{{ route('users.template') }}" download><i class="fa fa-download"></i> Download Template</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('import.users') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="form-group col-md-6 col-sm-12 p-3">
                                <label class="form-label">Upload Template File</label>
                                <input type="file" class="form-control template_file" id="template_file" name="template_file">

                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection