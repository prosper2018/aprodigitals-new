<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessDetails;
use App\Models\Department;
use App\Models\PayrollItems;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PayrollOverviewController extends Controller
{
    public function index(Request $request)
    {
        $overview = json_decode($this->getPayrollOverview($request), true);
        $total_staff = $overview['total_staff'] ?? 0.00;
        $total_salary = $overview['total_salary'] ?? 0.00;
        $staff_data  = User::select(['id', 'display_name', 'firstname', 'lastname'])->where(['is_deleted' => '0'])->get();
        $businesses = BusinessDetails::select(['id', 'business_name'])->where(['is_deleted' => '0'])->get();
        $departments = Department::select(['id', 'display_name'])->where(['is_deleted' => '0'])->get();
        return view('payroll.payroll_overview', compact('businesses', 'departments', 'staff_data', 'total_salary', 'total_staff'));
    }

    public function getPayrollOverview(Request $request)
    {
        $result = [];


        $month_input_string = $request->month ?? '';
        $department_id = $request->department_id ?? '';
        $staff_id = $request->staff_id ?? '';
        $position_id = $request->position_id ?? '';
        $business_id = $request->business_id ?? '';

        $month_input = explode('-', $month_input_string);
        $month = $month_input[1] ?? '';
        $year = $month_input[0] ?? '';

        $filter = ' 1 = 1 ';

        if ($business_id) {
            $filter .= " AND u.business_id = '$business_id' ";
        }
        if ($department_id) {
            $filter .= " AND u.department_id = '$department_id' ";
        }
        if ($position_id) {
            $filter .= " AND u.position_id = '$position_id' ";
        }
        if ($staff_id) {
            $filter .= " AND u.id = '$staff_id' ";
        }
        if ($month && $year) {
            $filter .= " AND (MONTH(pi.date_from) = '$month' OR MONTH(pi.date_to) = '$month') AND (YEAR(pi.date_from) = '$year' OR YEAR(pi.date_to) = '$year') ";
        }

        $query = PayrollItems::whereNotIn('payroll_items.is_deleted', [1])
            ->leftJoin('users as u', 'u.id', '=', 'payroll_items.staff_id')
            ->leftJoin('payrolls as pi', 'pi.id', '=', 'payroll_items.payroll_id')
            ->selectRaw('count(DISTINCT(payroll_items.staff_id)) as total_staff, sum(payroll_items.net) as total_salary')
            ->whereRaw($filter)
            ->first();
       
        if ($query) {
            $result['total_staff'] = number_format($query->total_staff);
            $result['total_salary'] = number_format($query->total_salary, 2);
        }

        return response()->json($result);
    }
}
