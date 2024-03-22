<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomResponse extends Controller
{
    protected function generateResponse(Request $request, $message, $type, $code = 20, $withinput = false)
    {
        if ($request->ajax()) {
            // Handle JSON response
            return response()->json(['response_code' => $code, 'response_message' => $message]);
        } else {
            // Handle other types of responses (e.g., HTML)
            if ($withinput) {
                return redirect()->back()->with($type,  $message)->withInput($request->all());
            } else {
                return redirect()->back()->with($type,  $message);
            }
        }
    }
}
