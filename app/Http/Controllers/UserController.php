<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BusinessDetails;
use App\Models\CountryCode;
use App\Models\Department;
use App\Models\Position;
use App\Models\Religion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Str;
use App\Http\Controllers\ThirdPartyApiController;
use App\Notifications\SendVerificationEmailNotification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Imports\UsersTemplateImport;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use Carbon\Carbon;
use Carbon\CarbonInterval;


class UserController extends Controller
{
    public function __construct()
    {
        // Check if the logos directory exists, and create it if not
        if (!Storage::exists('photos')) {
            Storage::makeDirectory('photos');
        }

        if (!Storage::exists('staffIDs')) {
            Storage::makeDirectory('staffIDs');
        }
    }

    public function index()
    {
        $country_codes = CountryCode::all();
        $banks = Bank::all();
        $religions = Religion::all();
        $businesses = BusinessDetails::select(['id', 'business_name'])->where(['is_deleted' => '0'])->get();
        $departments = Department::select(['id', 'display_name'])->where(['is_deleted' => '0'])->get();
        return view('user.register', compact('businesses', 'banks', 'departments', 'country_codes', 'religions'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'position_id' => ['required'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_phone' => ['required', 'int', 'max:255', 'unique:users'],
        ]);
    }


    public function validateAccountNumber(Request $request)
    {
        $thirdparty = new ThirdPartyApiController();
        return $thirdparty->verifyBankAccountNumber($request->bank_account_no, $request->bank_code);
    }


    public function store(Request $request)
    {
        if ($request->has('photo')) {
            $validator = Validator::make($request->all(), [
                'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:200'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('user.form')
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            // Upload the image to the specified directory
            $imageName = str_replace(' ', '_', $request->username) . '_' . time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('photos'), $imageName);
            $path = 'photos/' . $imageName;
        }

        if ($request->has('staff_id_card')) {
            $validator = Validator::make($request->all(), [
                'staff_id_card' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:200'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('user.form')
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            // Upload the image to the specified directory
            $imageName = str_replace(' ', '_', $request->username) . '_' . time() . '.' . $request->staff_id_card->extension();
            $request->staff_id_card->move(public_path('staffIDs'), $imageName);
            $staff_id_card_path = 'staffIDs/' . $imageName;
        }

        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
                'department_id' => ['required'],
                'position_id' => ['required'],
                'gender' => ['required'],
                'dob' => ['required'],
                'contact_address' => ['required'],
                'nationality' => ['required'],
                'religion' => ['required'],
                'marital_status' => ['required'],
                'employment_date' => ['required'],
                'termination_date' => ['required'],
                'employment_type' => ['required'],
                'business_id' => ['required'],
                'entry_salary' => ['required'],
                'current_salary' => ['required', 'numeric', 'min:0'],
                'current_usd_salary' => ['required', 'numeric', 'min:0'],
                'last_increment' => ['required', 'numeric', 'min:0'],
                'last_increment_date' => ['required'],
                'last_promotion' => ['required'],
                'bank_account_no' => ['required', 'numeric'],
                'bank_code' => ['required'],
                'bank_account_name' => ['required'],
                'firstname' => ['required', 'string', 'max:100'],
                'lastname' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'mobile_phone' => ['required', 'numeric', 'min:11', 'unique:users'],
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('user.form')
                ->withErrors($validator->errors())
                ->withInput();
        }

        $verificationToken = Str::random(60); // Generate a random 60-character string

        $data = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'position_id' => $request->position_id,
            'department_id' => $request->department_id,
            'dob' => $request->dob,
            'contact_address' => $request->contact_address,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'marital_status' => $request->marital_status,
            'employment_date' => $request->employment_date,
            'termination_date' => $request->termination_date,
            'employment_type' => $request->employment_type,
            'business_id' => $request->business_id,
            'entry_salary' => $request->entry_salary,
            'current_salary' => $request->current_salary,
            'current_usd_salary' => $request->current_usd_salary,
            'last_increment' => $request->last_increment,
            'last_increment_date' => $request->last_increment_date,
            'last_promotion' => $request->last_promotion,
            'photo' => $path,
            'staff_id_card' => $staff_id_card_path,
            'bank_account_no' => $request->bank_account_no,
            'bank_code' => $request->bank_code,
            'bank_account_name' => $request->bank_account_name,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' => $request->lastname . ' ' . $request->firstname,
            'mobile_phone' => $request->mobile_phone,
            'passchg_logon' => isset($request->passchg_logon) ? 1 : 0,
            'user_locked' => isset($request->user_locked) ? 1 : 0,
            'day_1' => isset($request->day_1) ? 1 : 0,
            'day_2' => isset($request->day_2) ? 1 : 0,
            'day_3' => isset($request->day_3) ? 1 : 0,
            'day_4' => isset($request->day_4) ? 1 : 0,
            'day_5' => isset($request->day_5) ? 1 : 0,
            'day_6' => isset($request->day_6) ? 1 : 0,
            'day_7' => isset($request->day_7) ? 1 : 0,
            // 'staff_id' => $request->staff_id,
            'posted_ip' => $request->ip(),
            'gender' => $request->gender,
            'verification_token' => $verificationToken,
        ];

        $send = User::create($data);

        if (!$send) {
            return redirect()->route('user.register')->with('error', 'Unable to Create User at the moment! Please, try again.');
        }

        // Send verification email
        $message = '<main style="padding: 20px;">
        <p>Please click the button below to verify your email address:</p>
        <a href="' . route('verify', $send->verification_token) . '" style="background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 5px;">Verify Email</a>
        <p>If you did not create an account, no further action is required.</p>
        </main> ';
        $send->notify(new SendVerificationEmailNotification(route('verify', $send->verification_token), $message));

        return redirect()->route('user.register')->with('success', 'User added successfully!');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view()
    {
        $users = User::all();
        return view('user.view', ['users' => $users]);
    }


    public function bulkUploadForm()
    {
        $users = User::all();
        return view('user.user_upload', ['users' => $users]);
    }


    public function viewall(Request $request)
    {
        $data = DB::table('users')->leftJoin('positions', 'users.position_id', '=', 'positions.position_id')
            ->select(['positions.position_name', 'users.id', 'users.username', 'users.firstname', 'users.lastname', 'users.mobile_phone', 'users.email', 'users.pin_missed', 'users.login_status', 'users.created_at']);

        if ($request->ajax()) {

            return datatables()->of($data)->toJson();
        }
        return view('user.view');
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $verify = $user->update([
            'verified' => true,
            'verification_token' => null,
            'email_verified_at' => NOW(),
        ]);

        if (!$verify) {
            return redirect()->route('login')->with('error', 'Unable to verify User at the moment! Please, try again.');
        }

        return redirect()->route('login')->with('success', 'Your email has been verified. You can now login.');
    }

    public function edit(User $user)
    {
        $position_details = Position::select('position_name', 'position_id')->where(['position_id' => $user->position_id])->first();
        $country_codes = CountryCode::all();
        $banks = Bank::all();
        $religions = Religion::all();
        $businesses = BusinessDetails::select(['id', 'business_name'])->where(['is_deleted' => '0'])->get();
        $departments = Department::select(['id', 'display_name'])->where(['is_deleted' => '0'])->get();
        return view('user.edit', compact('businesses', 'banks', 'departments', 'country_codes', 'religions', 'user', 'position_details'));
    }

    public function formatDate($dateTime)
    {
        // Assuming $dateTime is a datetime value
        $dateTime = Carbon::parse($dateTime);

        // Get the difference as a CarbonInterval object
        $diff = $dateTime->diff($dateTime);

        // Find the largest difference
        $difference = '';
        if ($diff->y > 0) {
            $difference = $diff->y . ' years ago';
        } elseif ($diff->m > 0) {
            $difference = $diff->m . ' months ago';
        } elseif ($diff->d > 0) {
            $difference = $diff->d . ' days ago';
        } elseif ($diff->h > 0) {
            $difference = $diff->h . ' hours ago';
        } elseif ($diff->i > 0) {
            $difference = $diff->i . ' minutes ago';
        } elseif ($diff->s > 0) {
            $difference = $diff->s . ' seconds ago';
        } elseif ($diff->days >= 7) {
            $weeks = floor($diff->days / 7);
            $difference = $weeks . ' weeks ago';
        }

        return $difference;
    }


    public function viewProfile(User $user)
    {
        $last_access = ($user->last_used == 0) ? '<span class="badge bg-danger">Never Accessed</span>' : $this->formatDate($user->last_used);
        $position_details = Position::select('position_name', 'position_id')->where(['position_id' => $user->position_id])->first();
        $country_codes = CountryCode::all();
        $banks = Bank::all();
        $religions = Religion::all();
        $business_details = BusinessDetails::select(['id', 'business_name'])->where(['id' => $user->business_id])->first();
        $department_details = Department::select(['id', 'display_name'])->where(['id' => $user->department_id])->first();
        return view('user.profile', compact('business_details', 'banks', 'department_details', 'country_codes', 'religions', 'user', 'position_details', 'last_access', 'business_details'));
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->has('photo')) {
            $validator = Validator::make($request->all(), [
                'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:200'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('users.edit', ['user' => $user->id])
                    ->withErrors($validator->errors());
            }

            // Upload the image to the specified directory
            $imageName = str_replace(' ', '_', $user->username) . '_' . time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('photos'), $imageName);
            $path = 'photos/' . $imageName;

            if (file_exists($user->photo)) {
                unlink($user->photo);
            }
        } else {
            $path = $user->photo;
        }

        if ($request->has('staff_id_card')) {
            $validator = Validator::make($request->all(), [
                'staff_id_card' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:200'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('users.edit', ['user' => $user->id])
                    ->withErrors($validator->errors());
            }

            // Upload the image to the specified directory
            $imageName = str_replace(' ', '_', $user->username) . '_' . time() . '.' . $request->staff_id_card->extension();
            $request->staff_id_card->move(public_path('staffIDs'), $imageName);
            $staff_id_card_path = 'staffIDs/' . $imageName;

            if (file_exists($user->staff_id_card)) {
                unlink($user->staff_id_card);
            }
        } else {
            $staff_id_card_path = $user->staff_id_card;
        }

        $validator = Validator::make(
            $request->all(),
            [
                'department_id' => ['required'],
                'position_id' => ['required'],
                'gender' => ['required'],
                'dob' => ['required'],
                'contact_address' => ['required'],
                'nationality' => ['required'],
                'religion' => ['required'],
                'marital_status' => ['required'],
                'employment_date' => ['required'],
                'termination_date' => ['required'],
                'employment_type' => ['required'],
                'business_id' => ['required'],
                'entry_salary' => ['required'],
                'current_salary' => ['required', 'numeric', 'min:0'],
                'current_usd_salary' => ['required', 'numeric', 'min:0'],
                'last_increment' => ['required', 'numeric', 'min:0'],
                'last_increment_date' => ['required'],
                'last_promotion' => ['required'],
                'bank_account_no' => ['required', 'numeric'],
                'bank_code' => ['required'],
                'bank_account_name' => ['required'],
                'firstname' => ['required', 'string', 'max:100'],
                'lastname' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
                'mobile_phone' => ['required', 'numeric', 'min:11', 'unique:users,mobile_phone,' . $id],
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('users.edit', ['user' => $user->id])
                ->withErrors($validator->errors());
        }

        $data = [
            'email' => $request->email,
            'position_id' => $request->position_id,
            'department_id' => $request->department_id,
            'dob' => $request->dob,
            'contact_address' => $request->contact_address,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'marital_status' => $request->marital_status,
            'employment_date' => $request->employment_date,
            'termination_date' => $request->termination_date,
            'employment_type' => $request->employment_type,
            'business_id' => $request->business_id,
            'entry_salary' => $request->entry_salary,
            'current_salary' => $request->current_salary,
            'current_usd_salary' => $request->current_usd_salary,
            'last_increment' => $request->last_increment,
            'last_increment_date' => $request->last_increment_date,
            'last_promotion' => $request->last_promotion,
            'photo' => $path,
            'staff_id_card' => $staff_id_card_path,
            'bank_account_no' => $request->bank_account_no,
            'bank_code' => $request->bank_code,
            'bank_account_name' => $request->bank_account_name,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'display_name' => $request->lastname . ' ' . $request->firstname,
            'mobile_phone' => $request->mobile_phone,
            'passchg_logon' => isset($request->passchg_logon) ? 1 : 0,
            'user_locked' => isset($request->user_locked) ? 1 : 0,
            'day_1' => isset($request->day_1) ? 1 : 0,
            'day_2' => isset($request->day_2) ? 1 : 0,
            'day_3' => isset($request->day_3) ? 1 : 0,
            'day_4' => isset($request->day_4) ? 1 : 0,
            'day_5' => isset($request->day_5) ? 1 : 0,
            'day_6' => isset($request->day_6) ? 1 : 0,
            'day_7' => isset($request->day_7) ? 1 : 0,
            // 'staff_id' => $request->staff_id,
            'gender' => $request->gender,
        ];

        $update = $user->update($data);

        if ($update > 0) {
            return redirect()->route('users.edit', ['user' => $user->id])->with('success', 'User Details updated successfully!');
        } else {
            return redirect()->route('users.edit', ['user' => $user->id])->with('error', 'User Details could not be updated at the momment!');
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_file' => 'required|mimes:xlsx,xls,csv',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.upload-form')->withErrors($validator->errors());
        }

        try {
            try {
                Excel::import(new UsersTemplateImport($request->ip(), 'template'), $request->file('template_file'));
            } catch (SheetNotFoundException $e) {
                $errors = $e->getMessage();
                return redirect()->back()->withErrors($errors)->withInput();
            }
            return redirect()->back()->with('success', 'Users imported successfully.');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }


    public function getStaffByDept(Request $request)
    {
        $sess_position_id = auth()->user()->position_id;
        $filter = ' 1 = 1';

        if ($sess_position_id != '100' && $sess_position_id != '200') {
            $filter = " AND is_management_staff NOT IN('1')";
        }

        $staff = User::whereNull('status')
            ->orWhere('status', '')
            ->where('department_id', $request->dept_id)
            ->where('position_id', '!=', 100)
            ->whereRaw($filter)
            ->orderBy('firstname', 'ASC')
            ->get(['id', 'firstname', 'lastname']);

        $saff_id = $staff->pluck('id')->toArray();
        $staff_name = $staff->map(function ($item) {
            return $item['firstname'] . ' ' . $item['lastname'];
        })->toArray();

        return response()->json(['option_id' => $saff_id, 'option_value' => $staff_name]);
    }
}
