<?php

namespace App\Http\Controllers;

use App\Models\BusinessDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    public function __construct()
    {
        // Check if the logos directory exists, and create it if not
        if (!Storage::exists('logos')) {
            Storage::makeDirectory('logos');
        }
    }

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
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->route('business.form')->withErrors($validator->errors());
        }

        // Upload the image to the specified directory
        $imageName = str_replace(' ', '_', $request->business_name) . '_' . time() . '.' . $request->logo->extension();
        $request->logo->move(public_path('logos'), $imageName);
        $imageUrl = 'logos/' . $imageName;

        try {

            BusinessDetails::create([
                'business_name' => $request->business_name,
                'address' => $request->address,
                'description' => $request->description,
                'logo' => $imageUrl,
                'posted_userid' => auth()->user()->id,
                'posted_user' => auth()->user()->username,
                'posted_ip' => $request->ip(),
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

    public function edit(BusinessDetails $business)
    {
        return view('business.update', [
            'business' => $business
        ]); //returns the edit view with the post
    }

    public function update(Request $request, $id)
    {
        $post = BusinessDetails::find($id);
        if ($request->has('logo')) {
            $validator = Validator::make($request->all(), [
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            if ($validator->fails()) {
                return redirect()->route('business.form')->withErrors($validator->errors());
            }

            // Upload the image to the specified directory
            $imageName = str_replace(' ', '_', $request->business_name) . '_' . time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('logos'), $imageName);
            $imageUrl = 'logos/' . $imageName;

            if (file_exists($post->logo)) {
                unlink($post->logo);
            }
        } else {
            $imageUrl = $post->logo;
        }

        $validator = Validator::make($request->all(), [
            'business_name' => 'required|unique:business_details,business_name,' . $id,
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $update = $post->update([
            'business_name' => $request->business_name,
            'address' => $request->address,
            'description' => $request->description,
            'logo' => $imageUrl,
        ]);

        if ($update > 0) {
            return redirect('businesses/' . $id . '/edit')->with('success', 'Business Details updated successfully!');
        } else {
            return redirect('businesses/' . $id . '/edit')->with('error', 'Business Details could not be updated at the momment!');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $delete = BusinessDetails::where('id', $id)->delete();

        if ($delete > 0) {
            return response()->json([
                "response_code" => 0,
                "response_message" => "Selected record deleted successfully"
            ]);
        } else {
            return response()->json([
                "response_code" => 1,
                "response_message" => "Action could not be Applied to selected record!"
            ]);
        }
    }
}
