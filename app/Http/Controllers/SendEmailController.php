<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Notifications\SendContactEmailNotification;

class SendEmailController extends Controller
{
    function index()
    {
        return view('contact');
    }

    function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  ['required'],
            'subject' =>  ['required'],
            'email' =>  ['required', 'email'],
            'message' =>  ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->route('contact')
                ->withErrors($validator->errors())
                ->withInput();
        }

        $appName = env("APP_NAME");
        
        // Send verification email
        $message = '<p>Dear Admin,</p>
         
             <p>We have received a new inquiry from a customer. Please find the details below:</p>
         
             <table style="width: 100%; border-collapse: collapse;">
                 <tr>
                     <th style="border: 1px solid #ddd; padding: 8px;">Customer Name</th>
                     <td style="border: 1px solid #ddd; padding: 8px;">' . $request->name . '</td>
                 </tr>
                 <tr>
                     <th style="border: 1px solid #ddd; padding: 8px;">Customer Email</th>
                     <td style="border: 1px solid #ddd; padding: 8px;">' . $request->email . '</td>
                 </tr>
                 <tr>
                     <th style="border: 1px solid #ddd; padding: 8px;">Inquiry</th>
                     <td style="border: 1px solid #ddd; padding: 8px;">' . $request->message . '</td>
                 </tr>
             </table>
         
             <p>Please take appropriate action and respond to the customer as soon as possible.</p>
         
             <p>Thank you.</p>
         
             <p>Best regards,<br>
             '.$appName.'</p>';

        try {
            $admins = User::where('position_id', '100')->get();

            foreach ($admins as $admin) {
                $admin->notify(new SendContactEmailNotification($message));
            }

            return back()->with('success', 'Thanks for contacting us!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
