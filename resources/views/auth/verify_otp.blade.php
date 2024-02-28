@extends('layouts.admin')
@section('content')

<style>
    .otp-inputs {
        display: flex;
        justify-content: center;
    }

    .otp-inputs input[type="text"] {
        width: 40px;
        margin: 0 5px;
        text-align: center;
    }
</style>
<div class="main d-flex justify-content-center w-100">
    <main class="content d-flex p-0">
        <div class="container d-flex flex-column">
            <div class="row h-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Welcome back</h1>
                            <p class="lead">
                                Please enter your otp to proceed
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center">
                                        <img src="/assets/img/logo-removebg-preview.png" alt="Chris Wood" class="img-fluid" width="132" height="132" />
                                    </div>
                                    <form action="{{ route('otp.verify') }}" method="post">
                                        @csrf
                                        <div class="otp-inputs py-4">
                                            <input type="text" name="otp[]" class="form-control" maxlength="1" pattern="[0-9]" required autofocus>
                                            <input type="text" name="otp[]" class="form-control" maxlength="1" pattern="[0-9]" required>
                                            <input type="text" name="otp[]" class="form-control" maxlength="1" pattern="[0-9]" required>
                                            <input type="text" name="otp[]" class="form-control" maxlength="1" pattern="[0-9]" required>
                                            <input type="text" name="otp[]" class="form-control" maxlength="1" pattern="[0-9]" required>
                                            <input type="text" name="otp[]" class="form-control" maxlength="1" pattern="[0-9]" required>
                                        </div>

                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Verify OTP</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var inputs = document.querySelectorAll('.otp-inputs input');

        inputs.forEach(function(input, index) {
            input.addEventListener('input', function() {
                if (this.value.length >= this.maxLength) {
                    // Move focus to the next input field
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                } else if (this.value.length === 0 && index > 0) {
                    // Move focus to the previous input field if the current input is empty
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>


@endsection