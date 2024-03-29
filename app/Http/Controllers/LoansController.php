<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LoanApplications;
use App\Models\LoanSchedules;
use App\Models\LoanTypes;
use App\Models\PendingRequests;
use App\Models\User;
use App\Notifications\NotificationEmail;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Validator;

class LoansController extends CustomResponse
{
    public function loanTypes()
    {
        return view('loan.loan-types');
    }

    public function loanSetupForm()
    {
        $sess_position_id = auth()->user()->position_id;
        $sess_department_id = auth()->user()->department_id;
        $dept_filter = ' 1 = 1';

        if ($sess_position_id != '100' && $sess_position_id != '200') {
            $dept_filter .= " AND id IN($sess_department_id)";
        }

        $departments = Department::select(['id', 'display_name'])->where(['is_deleted' => '0'])->whereRaw($dept_filter)->whereNull('deleted_at')->get();
        $loan_type = LoanTypes::select(['id', 'display_name'])->whereNull('deleted_at')->get();
        return view('loan.loan-setup', compact('departments', 'loan_type'));
    }

    public function loanEditForm($id)
    {
        // $loan = LoanApplications::findOrFail($id);
        $loan = DB::table('loan_applications')
        ->leftJoin('users', 'loan_applications.staff_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->select(['users.id', 'users.firstname', 'users.lastname', 'users.display_name as staff_name', 'users.gender', 'loan_applications.id', 'loan_applications.app_status', 'loan_applications.number_of_repayments', 'loan_applications.reason', 'loan_applications.amount', 'loan_applications.submitted_by', 'loan_applications.number_of_days', 'loan_applications.start_date', 'loan_applications.currency_type', 'loan_applications.ref_no', 'loan_applications.repayment_type', 'loan_applications.loan_type', 'departments.display_name as department_name'])->where('loan_applications.id', $id)->first();

        if(!$loan){
            return redirect()->intended('dashboard')
                ->with('error', 'Loan Account Not Found');
        }

        $sess_position_id = auth()->user()->position_id;
        $sess_department_id = auth()->user()->department_id;
        
        $loan_type = LoanTypes::select(['id', 'display_name'])->whereNull('deleted_at')->get();
        return view('loan.loan-edit', compact('loan_type', 'loan'));
    }

    public function editloanTypes($id)
    {
        $loan = LoanTypes::findOrFail($id);

        return view('loan.loan-types-edit', [
            'loan' => $loan
        ]);
    }

    public function loanTypeSetup(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'display_name' => 'required|unique:loan_types,display_name',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('loans.types')->withErrors($validator->errors())->withInput($data);
        }

        $datas['display_name'] = $request->display_name;
        $datas['description'] = $request->description;
        $datas['posted_ip'] = $request->ip();
        $datas['posted_user'] = auth()->user()->username;
        $datas['created_at'] = now();

        $loanType = LoanTypes::create($datas);

        if ($loanType) {
            return redirect()->route('loans.types')->with('success', 'Loan Type Created Successfully');
        } else {
            return redirect()->route('loans.types')->with('error', 'Loan Type Could not be Created');
        }
    }

    public function loanTypeUpdate(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'display_name' => 'required|unique:loan_types,display_name,' . $id,
            'description' => 'required'
        ], [
            'display_name.required' => 'Loan Type is required.',
            'description.required' => 'Description is required.'
        ]);

        if ($validator->fails()) {
            return redirect()->route('loans.types.edit', ['id' => $id])->withErrors($validator->errors())->withInput($data);
        }

        $loanType = LoanTypes::find($id);

        if (!$loanType) {
            return redirect()->route('loans.types.edit', ['id' => $id])->with('error', 'Loan Type not found');
        }

        try {
            $transaction_ok = true;

            DB::beginTransaction();

            // $before = $loanType->getOriginal();

            $update = $loanType->update([
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]);

            if ($update) {

                // $after = $loanType->getAttributes();

                if ($transaction_ok) {
                    DB::commit();
                    return redirect()->route('loans.types.edit', ['id' => $id])->with('success', 'Loan Type Updated Successfully');
                } else {
                    DB::rollback();
                    return redirect()->route('loans.types.edit', ['id' => $id])->with('error', 'Update Could not be Saved');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('loans.types.edit', ['id' => $id])->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function deleteLoanTypes(Request $request)
    {
        $id = $request->id;

        // Start a transaction
        DB::beginTransaction();

        try {
            $delete = LoanTypes::find($id)->delete();

            if ($delete > 0) {
                DB::commit();

                return response()->json([
                    "response_code" => 0,
                    "response_message" => "Selected record deleted successfully"
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    "response_code" => 1,
                    "response_message" => "Action could not be Applied to selected record!"
                ]);
            }
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'response_code' => 1,
                'response_message' => 'Oooops! Something went Wrong!' . $e->getMessage()
            ]);
        }
    }

    public function viewallLoanTypes(Request $request)
    {
        $data = LoanTypes::whereNull('deleted_at')->get();

        if ($request->ajax()) {
            return datatables()->of($data)->toJson();
        }
        return view('payroll.payroll-list');
    }

    public function approveSingleAppliction(Request $request)
    {
        $data = $request->all();

        if (isset($data['type']) && $data['type'] == 'approve') {
            $dat['approved_date'] = now();
            $dat['approved_by'] = auth()->id();
            $dat['app_status'] = 200;
            $success_message = 'Loan Application has been Approved successfully';
            $error_message = 'Loan Application could not be Approved, please try again!';
            $id = $data['ids'] ?? '';
        } elseif (isset($data['type']) && $data['type'] == 'reject') {
            $dat['rejection_date'] = now();
            $dat['rejected_by'] = auth()->id();
            $dat['app_status'] = 300;
            $success_message = 'Loan Application has been Rejected successfully';
            $error_message = 'Loan Application could not be Rejected, please try again!';
            $id = $data['rejected_id'] ?? '';
        } elseif (isset($data['type']) && $data['type'] == 'delete') {
            $success_message = 'Loan Application has been Deleted successfully';
            $error_message = 'Loan Application could not be Deleted, please try again!';
            $id = $data['ids'] ?? '';
        }

        $dat['comments_reason'] = $data['comments'] ?? '';

        if (empty($id)) {
            return $this->generateResponse($request, 'You have not selected any record, please select a record!', 'error', 20, true);
            // return redirect()->back()->with('error', 'You have not selected any record, please select a record!')->withInput($data);
        }

        try {
            DB::beginTransaction();
            $transaction_ok = true;

            $loanApplication = LoanApplications::findOrFail($id);
            if (isset($data['type']) && $data['type'] == 'delete') {
                $action = $loanApplication->delete();
            } else {
                $action = $loanApplication->update($dat);
            }
            if (!$action) {
                $transaction_ok = false;
            }


            // Update pending_requests
            $pending = PendingRequests::where('request_id', $id)
                ->where('request_type', 'loan')
                ->update(['status' => 1]);

            if (!$pending) {
                $transaction_ok = false;
            }

            // Update loan_schedules if needed
            if (isset($data['type']) && $data['type'] == 'delete') {
                $sch_delete = LoanSchedules::where('loan_id', $id)->delete();

                if (!$sch_delete) {
                    $transaction_ok = false;
                }
            }

            if ($transaction_ok == true) {

                if ($data['type'] != 'delete') {
                    $submitted_user = User::find($loanApplication->submitted_by);
                    $loan_app_user = User::find($loanApplication->staff_id);

                    $appName = env("APP_NAME");

                    $message = "<p>Dear, $submitted_user->display_name</p>";
                    $message .= "<p>Your loan application for " . $loan_app_user->display_name . " has been " . $data['type'] . "</p>";
                    $message .= ($data['type'] == 'reject') ? "<p><b>Reason: " . $dat['comments_reason'] . "</b></p>" : "";

                    $message .= "<p>Thank you.</p>
        
                        <p>Best regards,<br>
                        " . $appName . "</p>";

                    $subject = "Loan Application Status";

                    $submitted_user->notify(new NotificationEmail($message, $subject));
                }

                DB::commit();

                return $this->generateResponse($request, $success_message, 'success', 0, false);
            } else {
                DB::rollBack();
                return $this->generateResponse($request, $error_message, 'error', 20, false);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return $this->generateResponse($request, $error_message . ' ' . $e->getMessage(), 'error', 20, false);
        }
    }

    function approveMultipleAppliction(Request $request)
    {
        $data = $request->all();
        if (isset($data['type']) && $data['type'] == 'approve') {
            $dat['approved_date'] = date('Y-m-d h:i:s');
            $dat['approved_by'] =  auth()->id();;
            $dat['app_status'] = 200;
            $success_message = 'Selected records has been Approved successfully';
            $error_message = 'Selected records could not be Approved, please try again!';
            $type = (isset($data['type']) && $data['type'] != '') ? ucfirst($data['type'] . "d") : "";
        } elseif (isset($data['type']) && $data['type'] == 'reject') {
            $dat['rejection_date'] = date('Y-m-d h:i:s');
            $dat['rejected_by'] =  auth()->id();;
            $dat['app_status'] = 300;
            $success_message = 'Selected records has been Rejected successfully';
            $error_message = 'Selected records could not be Rejected, please try again!';
            $data['ids'] = $data['rejected_id'];
            $type = (isset($data['type']) && $data['type'] != '') ? ucfirst($data['type'] . "ed") : "";
        } elseif (isset($data['type']) && $data['type'] == 'delete') {
            $type = (isset($data['type']) && $data['type'] != '') ? ucfirst($data['type'] . "d") : "";
            $success_message = 'Selected records has been Deleted successfully';
            $error_message = 'Selected records could not be Deleted, please try again!';
        }

        $dat['comments_reason'] = (isset($data['comments']) && $data['comments'] != "") ? $data['comments'] : "";
        $type = (isset($data['type']) && $data['type'] != '') ? ucfirst($data['type'] . "ed") : "";
        $da['activity_type_id'] = 41;
        $da['posted_username'] = $_SESSION['cantina_username_sess'];

        $da['posted_ip'] = $_SERVER['REMOTE_ADDR'];

        try {
            DB::beginTransaction();
            $transaction_ok = true;

            if (!is_array($data['ids'])) {
                $string = $data['ids'];

                $datas = explode(',', $string);
                $counter = count($datas);
            } else {
                $counter = count($data['ids']);
                $datas = $data['ids'];
            }

            if (empty($datas)) {
                return $this->generateResponse($request, 'You have not selected any record, please select a record!', 'error', 20, false);
            } else {
                for ($i = 0; $i < $counter; $i++) {
                    $id = $datas[$i];

                    $loan_details = LoanApplications::findOrFail($id);
                    if (isset($data['type']) && $data['type'] == 'delete') {
                        $action = $loan_details->delete();
                    } else {
                        $action = $loan_details->update($dat);
                    }


                    if (!$action) {
                        $transaction_ok = false;
                    }

                    if ($data['type'] != 'delete') {
                        $submitted_user = User::find($loan_details->submitted_by);
                        $loan_app_user = User::find($loan_details->staff_id);

                        $appName = env("APP_NAME");

                        $message = "<p>Dear, $submitted_user->display_name</p>";
                        $message .= "<p>Your loan application for " . $loan_app_user->display_name . " has been " . $type . "</p>";
                        $message .= ($data['type'] == 'reject') ? "<p><b>Reason: " . $dat['comments_reason'] . "</b></p>" : "";

                        $message .= "<p>Thank you.</p>
         
                            <p>Best regards,<br>
                            " . $appName . "</p>";

                        $subject = "Loan Application Status";

                        $submitted_user->notify(new NotificationEmail($message, $subject));
                    }

                    // Update pending_requests
                    $pending = PendingRequests::where('request_id', $id)
                        ->where('request_type', 'loan')
                        ->update(['status' => 1]);

                    if (!$pending) {
                        $transaction_ok = false;
                    }

                    // Update loan_schedules if needed
                    if (isset($data['type']) && $data['type'] == 'delete') {
                        $sch_delete = LoanSchedules::where('loan_id', $id)->delete();

                        if (!$sch_delete) {
                            $transaction_ok = false;
                        }
                    }
                }
                if ($transaction_ok == true) {
                    DB::commit();
                    return $this->generateResponse($request, $success_message, 'success', 0, false);
                } else {
                    DB::rollback();
                    return $this->generateResponse($request, $error_message, 'error', 20, false);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();

            return $this->generateResponse($request, $error_message . ' ' . $e->getMessage(), 'error', 20, false);
        }
    }


    public function loanApplicationSetup(Request $request)
    {
        $data = $request->all();

        // Setting default value for currency_type if not provided
        $currency_type = $data['currency_type'] ?? 'naira';
        $data['currency_type'] = $currency_type;

        // Validation for repayment_type != 3
        if ($data['repayment_type'] != '3') {
            $validation = Validator::make($data, [
                'number_of_repayments' => 'required|min:0'
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation->errors())->withInput($data);
            }
        }

        // Validation for repayment_type == 2
        if ($data['repayment_type'] == '2') {
            $validation = Validator::make($data, [
                'number_of_days' => 'required|min:1|max:27'
            ], [
                'number_of_days.required' => 'Number of Days is required'
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation->errors())->withInput($data);
            }
        }



        // Set ref_no randomly
        $ref_no = mt_rand(1, 99999999);
        $data['ref_no'] = $ref_no;

        // Validation rules
        $validation = Validator::make($data, [
            'staff_id' => 'required',
            'loan_type' => 'required',
            'repayment_type' => 'required',
            'start_date' => 'required',
            'amount' => 'required|min:0'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput($data);
        }

        // Start a transaction
        DB::beginTransaction();

        $transaction_ok = true;

        try {

            $loan = LoanApplications::create([
                'ref_no' => $ref_no,
                'reason' => $request->reason,
                'staff_id' => $request->staff_id,
                'loan_type' => $request->loan_type,
                'repayment_type' => $request->repayment_type,
                'start_date' => $request->start_date,
                'submitted_by' => auth()->user()->id,
                'submitted_date' => $request->submitted_date,
                'loan_balance' => $request->amount,
                'number_of_days' => ($request->number_of_days == '') ? 1 : $request->number_of_days,
                'number_of_repayments' => ($request->number_of_repayments == '') ? 1 : $request->number_of_repayments,
                'currency_type' => $currency_type,
                'usd_amount' => ($currency_type == 'usd') ? $request->amount : 0,
                'amount' => $request->amount
            ]);

            if (!$loan) {
                $transaction_ok = false;
            }

            $id = $loan->id;


            $schedule = $this->generateLoanRepaymentSchedule($data['start_date'], $data['repayment_type'], $data['number_of_repayments'], $data['number_of_days'], $data['amount'], $id);

            if ($schedule != true) {
                $transaction_ok = false;
            }

            $user = DB::table('users')
                ->leftJoin('positions', 'users.position_id', '=', 'positions.position_id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->select(['positions.position_name', 'departments.display_name as department_name', 'users.display_name as full_name'])->first();


            $request_data = array(
                "link" => 'loan/manage',
                "description" => "A Loan requisition has been initiated for <b>" . $user->full_name . "</b> from <b> $user->department_name </b> Department",
                "request_id" => $id,
                "request_type" => 'loan',
                "staff_id" => $request->staff_id,
                "posted_user" => auth()->user()->username,
                "posted_userid" => auth()->user()->id,
                "posted_ip" => $request->ip()
            );
            $log_request = PendingRequests::create($request_data);
            if (!$log_request) {
                $transaction_ok = false;
            }


            if ($transaction_ok == true) {

                $admins = User::whereIn('position_id', [100, 200])->get();

                $appName = env("APP_NAME");

                $message = "<p>Hello Admin, </p><br><br>";
                $message .= "<p>Loan application has just been submitted for " . $user->full_name . " at " . date("F d, Y h:i:s A") . ".</p>";
                $message .= "<p>Please note that this application is pending your action! Kindly login to the system to carry out the required action!</p>";
                $message .= "<p>Thank you.</p>
         
                    <p>Best regards,<br>
                    " . $appName . "</p>";

                $subject = "Pending Loan Appliction";

                foreach ($admins as $admin) {
                    $admin->notify(new NotificationEmail($message, $subject));
                }

                $position_id = auth()->user()->position_id;
                if ($position_id == '100' || $position_id == '200') {
                    $approval_data = [
                        'type' => 'approve',
                        'ids' => $id
                    ];
                    $approval = new Request($approval_data);
                    $approve = $this->approveSingleAppliction($approval);
                    $response_message = FacadesSession::get('success');
                    if ($response_message) {
                        DB::commit();
                    } else {
                        DB::rollback();
                    }

                    return $approve;
                }

                DB::commit();

                return redirect()->back()->with('success', 'Loan Application Submitted Successfully.')->withInput($data);
            } else {
                DB::rollBack();

                return redirect()->back()->with('error', 'Oooops! Loan could not be submitted! Please try again.')->withInput($data);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Oooops! Something went Wrong!' . $e->getMessage())->withInput($data);
        }
    }
    public function loanApplicationEdit(Request $request, $id)
    {
        $loan = LoanApplications::findOrFail($id);
        $data = $request->all();

        // Setting default value for currency_type if not provided
        $currency_type = $data['currency_type'] ?? 'naira';
        $data['currency_type'] = $currency_type;

        // Validation for repayment_type != 3
        if ($data['repayment_type'] != '3') {
            $validation = Validator::make($data, [
                'number_of_repayments' => 'required|min:0'
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation->errors())->withInput($data);
            }
        }

        // Validation for repayment_type == 2
        if ($data['repayment_type'] == '2') {
            $validation = Validator::make($data, [
                'number_of_days' => 'required|min:1|max:27'
            ], [
                'number_of_days.required' => 'Number of Days is required'
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation->errors())->withInput($data);
            }
        }



        // Set ref_no randomly
        $ref_no = mt_rand(1, 99999999);
        $data['ref_no'] = $ref_no;

        // Validation rules
        $validation = Validator::make($data, [
            'loan_type' => 'required',
            'repayment_type' => 'required',
            'start_date' => 'required',
            'amount' => 'required|min:0'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput($data);
        }

        // Start a transaction
        DB::beginTransaction();

        $transaction_ok = true;

        try {

            $update = $loan->update([
                'reason' => $request->reason,
                'loan_type' => $request->loan_type,
                'repayment_type' => $request->repayment_type,
                'start_date' => $request->start_date,
                'loan_balance' => $request->amount,
                'number_of_days' => ($request->number_of_days == '') ? 1 : $request->number_of_days,
                'number_of_repayments' => ($request->number_of_repayments == '') ? 1 : $request->number_of_repayments,
                'currency_type' => $currency_type,
                'usd_amount' => ($currency_type == 'usd') ? $request->amount : 0,
                'amount' => $request->amount
            ]);

            if (!$update) {
                $transaction_ok = false;
            }


            $schedule = $this->generateLoanRepaymentSchedule($data['start_date'], $data['repayment_type'], $data['number_of_repayments'], $data['number_of_days'], $data['amount'], $id);

            if ($schedule != true) {
                $transaction_ok = false;
            }

            if ($transaction_ok == true) {

                $position_id = auth()->user()->position_id;
                if ($position_id == '100' || $position_id == '200') {
                    $approval_data = [
                        'type' => 'approve',
                        'ids' => $id
                    ];
                    $approval = new Request($approval_data);
                    $approve = $this->approveSingleAppliction($approval);
                    $response_message = FacadesSession::get('success');
                    if ($response_message) {
                        DB::commit();
                    } else {
                        DB::rollback();
                    }

                    return $approve;
                }

                DB::commit();

                return redirect()->back()->with('success', 'Loan Application Submitted Successfully.')->withInput($data);
            } else {
                DB::rollBack();

                return redirect()->back()->with('error', 'Oooops! Loan could not be submitted! Please try again.')->withInput($data);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Oooops! Something went Wrong!' . $e->getMessage())->withInput($data);
        }
    }

    public function generateLoanRepaymentSchedule($start_date, $repayment_type, $number_of_repayments, $number_of_days, $loan_amount, $loan_id)
    {
        $transaction_ok = true;

        // Check if there are existing loan schedules for this loan id
        $existingSchedules = LoanSchedules::where('loan_id', $loan_id)->get();

        // Delete existing loan schedules if found
        if ($existingSchedules->isNotEmpty()) {
            $deleted = LoanSchedules::where('loan_id', $loan_id)->forceDelete();
            if (!$deleted) {
                $transaction_ok = false;
            }
        }

        // Generate new loan schedules based on repayment type
        if ($repayment_type == '1') {
            $amount = ceil($loan_amount / $number_of_repayments);
            for ($i = 0; $i < $number_of_repayments; $i++) {
                $date = date("Y-m-d", strtotime($start_date . " +" . $i . " months"));
                $schedule = LoanSchedules::create([
                    'loan_id' => $loan_id,
                    'date_due' => $date,
                    'amount_due' => $amount,
                    'date_created' => now()
                ]);
                if (!$schedule) {
                    $transaction_ok = false;
                }
            }
        } elseif ($repayment_type == '3') {
            $schedule = LoanSchedules::create([
                'loan_id' => $loan_id,
                'date_due' => $start_date,
                'amount_due' => $loan_amount,
                'date_created' => now()
            ]);
            if (!$schedule) {
                $transaction_ok = false;
            }
        } elseif ($repayment_type == '2') {
            $amount = ceil($loan_amount / $number_of_repayments);
            $date_increment = $number_of_days;
            $date = $start_date;
            for ($i = 0; $i < $number_of_repayments; $i++) {
                $schedule = LoanSchedules::create([
                    'loan_id' => $loan_id,
                    'date_due' => $date,
                    'amount_due' => $amount,
                    'date_created' => now()
                ]);
                if (!$schedule) {
                    $transaction_ok = false;
                }
                $date = date("Y-m-d", strtotime($date . " +" . $date_increment . " days"));
            }
        } else {
            $schedule = LoanSchedules::create([
                'loan_id' => $loan_id,
                'date_due' => $start_date,
                'amount_due' => $loan_amount,
                'date_created' => now()
            ]);
            if (!$schedule) {
                $transaction_ok = false;
            }
        }

        return $transaction_ok;
    }

    public function loanApplicationList(Request $request)
    {
        $data = DB::table('loan_applications')
            ->leftJoin('loan_types', 'loan_applications.loan_type', '=', 'loan_types.id')
            ->leftJoin('users', 'loan_applications.staff_id', '=', 'users.id')
            ->select([
                'loan_types.display_name',
                'users.id',
                'users.photo',
                'users.firstname',
                'users.lastname',
                'users.display_name',
                'users.gender',
                'loan_applications.id',
                'loan_applications.app_status',
                'loan_applications.comments_reason',
                'loan_applications.reason',
                'loan_applications.amount',
                'loan_applications.submitted_by',
                'loan_applications.submitted_date',
                'loan_applications.start_date',
                'loan_applications.end_date',
                'loan_applications.ref_no',
                'loan_applications.created_at'
            ]);

        $status_value = $request->input('filter_type');
        if ($status_value != 'deleted') {
            $data->whereNull('loan_applications.deleted_at');
        }

        if ($request->has('filter_type')) {
            if ($status_value != '' && $status_value != 'all') {
                if ($status_value == 'pending') {
                    $data->where('app_status', '=', '100');
                } else if ($status_value == 'approved') {
                    $data->where('app_status', '=', '200');
                } else if ($status_value == 'rejected') {
                    $data->where('app_status', '=', '300');
                } else if ($status_value == 'deleted') {
                    // Include deleted records
                    $data->whereNotNull('loan_applications.deleted_at');
                }
            }
        }

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        if ($start_date != '' && $end_date != '') {
            $data->whereBetween('loan_applications.created_at', [$start_date, $end_date]);
        }

        if ($start_date != '' && $end_date == '') {
            $data->whereDate('loan_applications.created_at', $start_date);
        }

        if ($start_date == ''  && $end_date != '') {
            $data->whereDate('loan_applications.created_at', '<=', $end_date);
        }

        $data->get();

        if ($request->ajax()) {
            return datatables()->of($data)->toJson();
        }
        return view('loan.manage-loan');
    }

    public function loanApplications(Request $request)
    {
        $sess_position_id = auth()->user()->position_id;
        $submitted_by_id = auth()->user()->id;

        $data = DB::table('loan_applications')
            ->leftJoin('loan_types', 'loan_applications.loan_type', '=', 'loan_types.id')
            ->leftJoin('users', 'loan_applications.staff_id', '=', 'users.id')
            ->select([
                'loan_types.display_name',
                'users.id',
                'users.photo',
                'users.firstname',
                'users.lastname',
                'users.display_name',
                'users.gender',
                'loan_applications.id',
                'loan_applications.app_status',
                'loan_applications.comments_reason',
                'loan_applications.reason',
                'loan_applications.amount',
                'loan_applications.submitted_by',
                'loan_applications.submitted_date',
                'loan_applications.start_date',
                'loan_applications.end_date',
                'loan_applications.ref_no',
                'loan_applications.created_at'
            ])
            ->selectRaw('(SELECT display_name FROM users WHERE id = loan_applications.submitted_by) as submitted_by_name');

        $status_value = $request->input('filter_type');
        if ($status_value != 'deleted') {
            $data->whereNull('loan_applications.deleted_at');
        }

        if ($request->has('filter_type')) {
            if ($status_value != '' && $status_value != 'all') {
                if ($status_value == 'pending') {
                    $data->where('app_status', '=', '100');
                } else if ($status_value == 'approved') {
                    $data->where('app_status', '=', '200');
                } else if ($status_value == 'rejected') {
                    $data->where('app_status', '=', '300');
                } else if ($status_value == 'deleted') {
                    // Include deleted records
                    $data->whereNotNull('loan_applications.deleted_at');
                }
            }
        }

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        if ($start_date != '' && $end_date != '') {
            $data->whereBetween('loan_applications.created_at', [$start_date, $end_date]);
        }

        if ($start_date != '' && $end_date == '') {
            $data->whereDate('loan_applications.created_at', $start_date);
        }

        if ($start_date == ''  && $end_date != '') {
            $data->whereDate('loan_applications.created_at', '<=', $end_date);
        }

        if ($sess_position_id != '100' && $sess_position_id != '200') {
            $data->where('loan_applications.submitted_by', '=', $submitted_by_id);
        }

        $data->get();

        if ($request->ajax()) {
            return datatables()->of($data)->toJson();
        }
        return view('loan.loan-applications');
    }

    public function loanApplicationView($id)
    {
        $loandetails = DB::table('loan_applications')
            ->leftJoin('loan_types', 'loan_applications.loan_type', '=', 'loan_types.id')
            ->leftJoin('users', 'loan_applications.staff_id', '=', 'users.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.position_id')
            ->leftJoin('business_details', 'users.business_id', '=', 'business_details.id')
            ->select(['loan_types.display_name', 'users.id', 'users.photo', 'users.firstname', 'users.lastname', 'users.display_name as staff_name', 'users.gender', 'loan_applications.id', 'loan_applications.app_status', 'loan_applications.comments_reason', 'loan_applications.reason', 'loan_applications.amount', 'loan_applications.submitted_by', 'loan_applications.submitted_date', 'loan_applications.start_date', 'loan_applications.end_date', 'loan_applications.ref_no', 'loan_applications.repayment_type', 'departments.display_name as department_name', 'positions.position_name', 'business_details.business_name'])
            ->selectRaw('(SELECT display_name FROM users WHERE id = loan_applications.submitted_by) as submitted_by_name')
            ->where('loan_applications.id', $id)->first();

        $schedules = LoanSchedules::where('loan_id', $loandetails->id)->get();
        return view('loan.loan-view', compact('loandetails', 'schedules'));
    }
}
