@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8">
            @if (count($errors)>0)
            <div class="card mt-5">
                <div class="card-body">
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>    
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Edit Position') }}</div>

                <form action="{{ route('positions.update', $role->position_id) }}" method="post" enctype="multipart/form-data">  @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row mb-3">
                        <label for="position_id" class="col-md-4 col-form-label text-md-end">{{ __('Position ID') }}</label>

                        <div class="col-md-6">
                            <input id="position_id" type="text" class="form-control @error('position_id') is-invalid @enderror" name="position_id" value="{{ $role->position_id }}" required autocomplete="position_id" autofocus disabled>

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
                            <input id="position_name" type="text" class="form-control @error('position_name') is-invalid @enderror" name="position_name" value="{{ $role->position_name  }}" required autocomplete="position_name" autofocus>

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
                                <option value="1" {{ ($role->position_enabled == 1) ? "selected" : ""  }}>Yes</option>
                                <option value="0" {{ ($role->position_enabled == 0) ? "selected" : ""  }}>No</option>
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
                                <option value="1" {{ ($role->requires_login == 1) ? "selected" : ""  }}>Yes</option>
                                <option value="0" {{ ($role->requires_login == 0) ? "selected" : ""  }}>No</option>
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
<script>
    select();
</script>
@endsection
