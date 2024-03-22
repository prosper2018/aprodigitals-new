@extends('layouts.adminlayout')

@section('title', config("app.name").' - Loans')

@section('content')

<div class="main_content_iner py-4">

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <section class="forms">
                <div class="card card_border py-2 mb-4">
                    <div class="card-body col-lg-12">
                        <div class="tab-content">

                            <div class="row" style="margin-bottom:0px; margin-top:30px;">
                                <div class="col-lg-3 col-md-3 col-sm-12 py-2" id="att_name_div">
                                    <label for="keywords">Start Date:</label>
                                    <div class="att-section">
                                        <input type="date" class="form-control" name="start_date" id="start_date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 py-2" id="att_name_div">
                                    <label for="keywords">End Date:</label>
                                    <div class="att-section">
                                        <input type="date" class="form-control" name="end_date" id="end_date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 py-2" id="filter_div">
                                    <label for="filter_type">Filter By:</label><br>
                                    <select id="filter_type" class="form-control select" id="filter_type">
                                        <option value="">:::Select Option:::</option>
                                        <option value="all">ALL</option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                        <input type="hidden" id="id">
                                        <input class="ids" type="hidden" id="ids" name="ids[]" value="" />
                                    </select>
                                </div>

                                <div class="col-sm-12 col-lg-2 col-md-2 py-4">
                                    <label for="search">&nbsp;</label>
                                    <button id="apply_loan_applications_filter" class="btn btn-primary btn-block"><span class="fa fa-search"></span></button>
                                </div>
                            </div>
                            <!--  -->
                        </div>
                    </div>
                </div>

            </section>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Loan Applications</h3>

                        </div>
                        <div class="card-body">
                            <table id="loan-loanapplications" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                    <th scope="col">S/N</th>
                                        <th scope="col"></th>
                                        <th scope="col">name</th>
                                        <th scope="col">Loan Ref</th>
                                        <th scope="col">status</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Submitted By</th>
                                        <th scope="col">Application Date</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">Action</th>
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
    </div>
</div>

<div class="modal fade" id="confirmpay" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="modal_div">


        </div>
    </div>
</div>

<div class="modal fade" id="confirmRejecton" data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" id="reject_modal">

            <div class="modal-header">
                <h5 class="modal-title">Enter Rejection Reason and click proceed </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form autocomplete="off" id="form1" class="form-material" method="POST" action="{{ route('loans.manage.single-action') }}">
                @csrf
                <div class="modal-body m-3">
                    <div class="row">

                        <input name="type" value="" id="type" type="hidden">
                        <input name="rejected_id" value="" id="rejected_id" type="hidden">

                        <div class="form-outline">
                            <label class="form-label" for="textAreaExample3">Reason For Rejection </label>
                            <textarea class="form-control" id="textAreaExample3" name="comments" rows="2"></textarea>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <button class="btn btn-lg btn-success" type="submit"> Proceed</button>

                        </div>
                        <div class="mb-3 col-md-6">
                            <input class="btn btn-lg btn-warning" type="button" value="Back" data-bs-dismiss="modal" aria-label="Close" />

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog" role="document">
        <div class="modal-content" id="app_modal_div">

        </div>
    </div>
</div>

@endsection