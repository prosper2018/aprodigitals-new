@extends('layouts.admin')

@section('content')
<div class="wrapper">
    @include('layouts.partials.sidebar')
    <div class="main">
        @include('layouts.partials.top_menubar')
        <div class="container" style="padding-top: 40px !important;">
            <div class="row justify-content-center">

                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">{{ __('positions') }}</div>

                        <form action="{{ route('positions.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="row mb-3">
                                    <label for="position_id" class="col-md-4 col-form-label text-md-end">{{ __('Position ID') }}</label>

                                    <div class="col-md-6">
                                        <input id="position_id" type="text" class="form-control @error('position_id') is-invalid @enderror" name="position_id" value="{{ old('position_id') }}" required autocomplete="position_id" autofocus>

                                        @error('position_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="position_name" class="col-md-4 col-form-label text-md-end">{{ __('Position Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="position_name" type="text" class="form-control @error('position_name') is-invalid @enderror" name="position_name" value="{{ old('position_name') }}" required autocomplete="position_name" autofocus>

                                        @error('position_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="position_enabled" class="col-md-4 col-form-label text-md-end">{{ __('Position Enabled') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control select  @error('position_enabled') is-invalid @enderror" name="position_enabled" id="position_enabled" style="width: 100% !important;">
                                            <option value="">::select option::</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        @error('position_enabled')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="requires_login" class="col-md-4 col-form-label text-md-end">{{ __('Requires Login') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control select  @error('requires_login') is-invalid @enderror" name="requires_login" id="requires_login" style="width: 100% !important;">
                                            <option value="">::select option::</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        @error('requires_login')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    select();
</script>
@endsection