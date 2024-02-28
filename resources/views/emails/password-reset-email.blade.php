<div class="container d-flex flex-column">
    <div class="row h-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                <div class="text-center mt-4">
                    <h1 class="h2"> Hello {{ $name }},</h1>

                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="m-sm-4">
                            <div class="text-center" style="margin-bottom: 10px;">
                                <img src="/assets/img/logo.jpeg" alt="Cantina Logo" class="img-fluid rounded-circle" width="132" height="132" />
                            </div>

                            You have requested to reset your password. Please click the following link to reset your password:

                            {{ $data['link'] }}
                            <br><br> OR <br><br>
                            <a href="{{$data['link']}}" class="btn btn-primary">Click here</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection