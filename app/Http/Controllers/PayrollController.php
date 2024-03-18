<?php

namespace App\Http\Controllers;

use App\Models\LoanTypes;
use App\Models\PayrollItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Payrolls;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index()
    {
        return view('payroll.payroll-setup');
    }

    public function payrollList(Request $request)
    {
        $data = DB::table('payrolls')
            ->select(['id', 'ref_no', 'date_from', 'date_to', 'payroll_type', 'status', 'posted_user', 'posted_ip', 'posted_userid', 'is_deleted', 'created_at'])
            ->whereRaw('is_deleted NOT IN(1)')
            ->whereNull('deleted_at');

        if ($request->ajax()) {
            return datatables()->of($data)->toJson();
        }
        return view('payroll.payroll-list');
    }

    public function payrollSetup(Request $request)
    {
        $data = $request->all();

        $date_check = ($data['date_from'] != '' && $data['date_to'] != '') ? $this->getNumberOfWeeks($data['date_from'], $data['date_to']) : 0;

        if (isset($data['payroll_type']) && $data['payroll_type'] == 1) {
            if ($date_check > 4) {
                return redirect()->route('payroll.setup-form')->with('error',  "You cannot create a payroll period greater than 1 month!")->withInput($data);
            } elseif ($date_check < 4) {
                return redirect()->route('payroll.setup-form')->with('error',  "You cannot create a payroll period less than 1 month! Please use the Semi-Monthly option instead")->withInput($data);
            }
        } elseif (isset($data['payroll_type']) && $data['payroll_type'] == 2 && $date_check > 4) {
            return redirect()->route('payroll.setup-form')->with('error',  "You cannot create a payroll period greater than 1 month!")->withInput($data);
        }

        $validator = Validator::make($data, [
            'payroll_type' => 'required',
            'date_from' => 'required|unique:payrolls,date_from,',
            'date_to' => 'required|unique:payrolls,date_to,',
        ], [
            'payroll_type.required' => 'Payroll Type is required.',
            'date_from.required' => 'Start Date is required.',
            'date_to.required' => 'End Date is required.',
            'date_from.unique' => 'Payroll with this start date already exist.',
            'date_to.unique' => 'Payroll with this end date already exist.',
        ]);

        if ($validator->fails()) {
            $failedRules = $validator->failed();
            $isUniqueDateFrom = isset($failedRules['date_from']['Unique']);
            $isUniqueDateTo = isset($failedRules['date_to']['Unique']);

            if ($isUniqueDateFrom || $isUniqueDateTo) {
                // Check if a soft-deleted record exists with the same date_from and date_to
                $duplicatePayroll = Payrolls::onlyTrashed()
                    ->where('date_from', $data['date_from'])
                    ->where('date_to', $data['date_to'])
                    ->first();

                if ($duplicatePayroll) {
                    // Restore the soft-deleted record
                    $duplicatePayroll->restore();

                    // Optionally, you can update the restored record with new data if needed
                    $duplicatePayroll->update([
                        'payroll_type' => $request->payroll_type,
                        'date_from' => $request->date_from,
                        'date_to' => $request->date_to,
                    ]);

                    return redirect()->route('payroll.setup-form')->with('success',  'Payroll Created Successfully');
                }
            }

            // If validation fails and it's not a duplicate record
            if (!($isUniqueDateFrom && $isUniqueDateTo)) {
                return redirect()->route('payroll.setup-form')->withErrors($validator->errors())->withInput($data);
            }

            return redirect()->route('payroll.setup-form')->withErrors($validator->errors())->withInput($data);
        }


        $date_from = $data['date_from'] ?? '';
        $date_to = $data['date_to'] ?? '';
        if ($date_to < $date_from) {
            return redirect()->route('payroll.setup-form')->with('error',  "Your end date [$date_to] must be greater than start date [$date_from]")->withInput($data);
        }

        $ref_no = date('Y') . '-' . mt_rand(1, 9999);
        $datas['payroll_type'] = $request->payroll_type;
        $datas['date_from'] = $request->date_from;
        $datas['date_to'] = $request->date_to;
        $datas['ref_no'] = $ref_no;
        $datas['posted_ip'] = $request->ip();
        $datas['posted_user'] = auth()->user()->username;
        $datas['posted_userid'] = auth()->user()->id;

        try {

            DB::beginTransaction();
            $count = Payrolls::create($datas);
            if ($count) {
                DB::commit();
                return redirect()->route('payroll.setup-form')->with('success',  'Payroll Created Successfully');
            } else {
                DB::rollBack();
                return redirect()->route('payroll.setup-form')->with('error', 'Payroll Could not be Created')->withInput($data);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('payroll.setup-form')->with('error',  'Oooops! Something went Wrong! ' . $e->getMessage())->withInput($data);
        }
    }

    public function payrollUpdate(Request $request, $id)
    {
        $payroll = Payrolls::findOrFail($id);
        $type = 'edit';
        $data = $request->all();

        $date_check = ($data['date_from'] != '' && $data['date_to'] != '') ? $this->getNumberOfWeeks($data['date_from'], $data['date_to']) : 0;

        if (isset($data['payroll_type']) && $data['payroll_type'] == 1) {
            if ($date_check > 4) {
                return redirect()->route('payroll.setup-edit', ['id' => $id])->with('error',  "You cannot create a payroll period greater than 1 month!")->withInput($data);
            } elseif ($date_check < 4) {
                return redirect()->route('payroll.setup-edit', ['id' => $id])->with('error',  "You cannot create a payroll period less than 1 month! Please use the Semi-Monthly option instead")->withInput($data);
            }
        } elseif (isset($data['payroll_type']) && $data['payroll_type'] == 2 && $date_check > 4) {
            return redirect()->route('payroll.setup-edit', ['id' => $id])->with('error',  "You cannot create a payroll period greater than 1 month!")->withInput($data);
        }


        $validator = Validator::make($data, [
            'payroll_type' => 'required',
            'date_from' => 'required|unique:payrolls,date_from,' . $id,
            'date_to' => 'required|unique:payrolls,date_to,' . $id,
        ], [
            'payroll_type.required' => 'Payroll Type is required.',
            'date_from.required' => 'Start Date is required.',
            'date_to.required' => 'End Date is required.',
            'date_from.unique' => 'Payroll with this start date already exist.',
            'date_to.unique' => 'Payroll with this end date already exist.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('payroll.setup-edit', ['id' => $id])->withErrors($validator->errors())->withInput($data);
        }

        $date_from = $data['date_from'] ?? '';
        $date_to = $data['date_to'] ?? '';
        if ($date_to < $date_from) {
            return redirect()->route('payroll.setup-edit', ['id' => $id])->with('error',  "Your end date [$date_to] must be greater than start date [$date_from]")->withInput($data);
        }


        $operation = $type;

        $datas['payroll_type'] = $request->payroll_type;
        $datas['date_from'] = $request->date_from;
        $datas['date_to'] = $request->date_to;

        try {
            DB::beginTransaction();
            $count = $payroll->update($datas);
            if ($count) {
                $before = DB::table('payrolls')->where('id', $id)->first();
                // Log changes locally

                // if (!$logged) {
                // DB::rollBack();
                // return redirect()->route('payroll.setup-edit', ['id' => $id])->with('success',  'Update Could not be Saved']);
                // }
                DB::commit();
                return redirect()->route('payroll.setup-edit', ['id' => $id])->with('success',  'Payroll Updated Successfully');
            } else {
                DB::rollBack();
                return redirect()->route('payroll.setup-edit', ['id' => $id])->with('error',  'You have not made any changes')->withInput($data);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('payroll.setup-edit', ['id' => $id])->with('error',  'Oooops! Something went Wrong!' . $e->getMessage())->withInput($data);
        }
    }

    public function edit($id)
    {
        $payroll = Payrolls::findOrFail($id);

        return view('payroll.payroll-update', [
            'payroll' => $payroll
        ]);
    }


    public function getNumberOfWeeks($start_date, $end_date)
    {
        if ($start_date > $end_date) {
            return $this->getNumberOfWeeks($end_date, $start_date);
        }

        $first = Carbon::createFromFormat('Y-m-d', $start_date);
        $second = Carbon::createFromFormat('Y-m-d', $end_date);

        return floor($first->diffInDays($second) / 7);
    }

    public function deletePayroll(Request $request)
    {
        $id = $request->id;

        // Start a transaction
        DB::beginTransaction();

        try {
            $delete = Payrolls::find($id)->delete();
            $delete_payroll = PayrollItems::where('payroll_id', $id)->delete();

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

}
