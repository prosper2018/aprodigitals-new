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
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Business Setup</h4>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="update" enctype="multipart/form-data">
                        @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                        </div>
                        @elseif(session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12 p-3">
                                <label class="form-label">
                                    Business Name
                                </label>
                                <input type="text" class="form-control" wire:model="business_name" name="business_name" value="" placeholder="Business Name" autocomplete="off">
                                @error('business_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-6 col-sm-12 p-3">
                                <label class="form-label">Business Address</label>
                                <textarea class="form-control" wire:model="address" name="address"></textarea>
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-6 col-sm-12 p-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" wire:model="description" name="description"></textarea>
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-6 col-sm-12 p-3">
                                <label class="form-label">Business Logo</label>
                                <input type="file" wire:model="logo">

                                @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="logo" class="text-info">Uploading...</div>

                            </div>
                            <div class="form-group col-md-6 col-sm-12 p-3"> 
                                Photo Preview:
                                @if (is_string($logo) || $logo === null)
                                <img src="{{ $logo }}" width="100px" height="100px">
                                @else
                                <img src="{{ $logo->temporaryUrl() }}" width="100px" height="100px">
                                @endif

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