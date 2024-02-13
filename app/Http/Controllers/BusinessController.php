<?php

namespace App\Http\Controllers;

use App\Models\BusinessDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index()
    {
        return view('business.business-setup');
    }

    public function view()
    {
        return view('business.all-businesses');
    }

    public function storeBusiness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => ['required', 'unique:business_details'],
            'address' => 'required',
            'logo' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('business.form')->withErrors($validator->errors());
        }

        $ext = pathinfo($request->logo->getRealPath(), PATHINFO_EXTENSION);
        $path = $request->logo->storeAs('photos', str_replace(' ', '_', $request->business_name . '.' . $ext));

        try {

            BusinessDetails::create([
                'business_name' => $request->business_name,
                'address' => $request->address,
                'description' => $request->description,
                'logo' => $path
            ]);

            return redirect()->route('business.form')->with('success', 'Business Created Successfully!!');
        } catch (\Exception $ex) {
            return redirect()->route('business.form')->with('error', 'Records submission failed!' . $ex->getMessage());
        }
    }

    public function viewAllBusiness(Request $request)
    {
        $data = BusinessDetails::query()
            ->select('business_details.*', DB::raw('(SELECT COUNT(business_id) FROM users WHERE users.business_id = business_details.id) AS total_staff'), DB::raw('(SELECT COUNT(business_id) FROM users WHERE users.business_id = business_details.id AND status NOT IN(1) AND is_deleted NOT IN(1)) AS total_active_staff'), DB::raw('(SELECT SUM(current_salary) FROM users WHERE users.business_id = business_details.id AND status NOT IN(1) AND is_deleted NOT IN(1)) AS total_salary'));

        // Apply search filter if search term is provided
        if ($request->has('business_name')) {
            $business_name = $request->input('business_name');
            // Apply filter to query
            $data->where('business_name', 'like', '%' . $business_name . '%');
        }

        if ($request->has('status')) {
            $status_value = $request->input('status');
            if ($status_value == 'active') {
                $data->where('is_deleted', '!=', '1');
            } else if ($status_value == 'inactive') {
                $data->where('is_deleted', '=', '1');
            }
        }

        $data->get();

        return datatables()->of($data)->toJson();
    }
}
