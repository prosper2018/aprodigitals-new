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
            ->select('business_details.*', DB::raw('(SELECT COUNT(business_id) FROM users WHERE users.business_id = business_details.id) AS total_staff'), DB::raw('(SELECT COUNT(business_id) FROM users WHERE users.business_id = business_details.id AND status NOT IN(1) AND is_deleted NOT IN(1)) AS total_active_staff'), DB::raw('(SELECT SUM(current_salary) FROM users WHERE users.business_id = business_details.id AND status NOT IN(1) AND is_deleted NOT IN(1)) AS total_salary'))
            ->get();

        // Apply search filter if search term is provided
        // if ($request->has('search')) {
        //     $search = $request->input('search');
        //     $data->where('column_name', 'like', "%$search%");
        // }

        // Apply filters if filter parameters are provided
        // Example: $request->input('filter_column') 

        return datatables()->of($data)->toJson();
    }
}
