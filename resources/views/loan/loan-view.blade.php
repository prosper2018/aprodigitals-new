@extends('layouts.adminlayout')

@section('title', config("app.name").' - Loans')

@section('content')

<div class="container-fluid py-4">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-header">
                        <h5 class="card-title">Loan Application Details</h5>
                    </div>
                    <div class="card-body m-3">

                        <table class="table table-sm my-1">
                            <tbody>
                                <tr>
                                    <th>Applicant Name</th>
                                    <td>
                                        {{ $loandetails->firstname . " " . $loandetails->lastname }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Staff ID</th>
                                    <td>{{ $loandetails->id }}</td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td>{{ $loandetails->department_name }}</td>
                                </tr>
                                <tr>
                                    <th>Position</th>
                                    <td>{{ $loandetails->position_name }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ ucfirst($loandetails->gender) }}</td>
                                </tr>

                                <tr>
                                    <th>Business</th>
                                    <td>{{ $loandetails->business_name }}</td>
                                </tr>
                                <tr>
                                    <th>Loan Ref</th>
                                    <td>{{ $loandetails->ref_no }}</td>
                                </tr>
                                <tr>
                                    <th>Loan Amount</th>
                                    <td>{{ number_format($loandetails->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Loan Type</th>
                                    <td>{{ $loandetails->display_name }}</td>
                                </tr>
                                <tr>
                                    <th>Loan Start Date</th>
                                    <td>{{ $loandetails->start_date }}</td>
                                </tr>
                                <tr>
                                    <th>Loan End Date</th>
                                    <td>{{ $loandetails->end_date }}</td>
                                </tr>
                                <tr>
                                    <th>Repayment Frequency</th>
                                    <td><?php
                                        switch ($loandetails->repayment_type) {
                                            case '1':
                                                $label = 'Monthly';
                                                break;
                                            case '2':
                                                $label = 'Semi-Mothly';
                                                break;
                                            case '3':
                                                $label = 'Once';
                                                break;
                                            default:
                                                $label = "";
                                                break;
                                        }
                                        echo $label ?></td>
                                </tr>

                                <tr>
                                    <th>Reason</th>
                                    <td>{{ $loandetails->reason }}</td>
                                </tr>
                                <tr>
                                    <th>Submitted By</th>
                                    <td>{{ $loandetails->submitted_by_name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php
                                        switch ($loandetails->app_status) {
                                            case '100':
                                                $label = '<span class="badge bg-warning">Pending</span>';
                                                break;
                                            case '200':
                                                $label = '<span class="badge bg-success">Approved</span>';
                                                break;
                                            case '300':
                                                $label = '<span class="badge bg-danger">Rejected</span>';
                                                break;
                                            default:
                                                $label = "";
                                                break;
                                        }
                                        echo $label ?></td>
                                </tr>
                                @if ($loandetails->app_status == '300')
                                <tr>
                                    <th>Rejection Reason/Comments</th>
                                    <td>{{ $loandetails->comments_reason }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <h3 class="card-title my-3">Loan Repayment Schedule</h3>
                        @if ($schedules)
                        <table class="table table-sm my-2 table-striped" style="width:100%" id="responsive_table">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Due Date</th>
                                    <th>Due Amount</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total_amount = 0;
                                $sno = 1;
                                foreach ($schedules as $row) {
                                    $total_amount += $row['amount_due'];
                                ?>
                                    <tr>
                                        <td>{{ $sno++ }}</td>
                                        <td>{{ $row['date_due'] }}</td>
                                        <td>{{ number_format($row['amount_due'], 2) }}</td>
                                        <td>@if ($row['status'] == 1)
                                            <span class="badge bg-success">Paid</span>
                                            @else
                                            @if($row['paid_amount'] > 0)
                                            <span class="badge bg-warning">Partially Paid</span>
                                            @else
                                            <span class="badge bg-danger">Pending</span>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th>{{ number_format($total_amount, 2) }}</th>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection