<?php

namespace App\Http\Controllers;

use App\Models\BusinessDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index()
    {
        return view('business.business-setup');
    }

    public function storeBusiness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => ['required', 'unique:business_details'],
            'address' => 'required',
            'logo' => 'required'
        ]);

        if($validator->fails()){
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
            // $this->dispatchBrowserEvent('swal:modal', [
            //     'type' => 'success',
            //     'message' => 'Successful!',
            //     'text' => 'Business Created Successfully!!'
            // ]);

            // $this->resetInputFields();
            return redirect()->route('business.form')->with('success', 'Business Created Successfully!!');
        } catch (\Exception $ex) {
            return redirect()->route('business.form')->with('error', 'Records submission failed!'. $ex->getMessage());
        }
    }
}
