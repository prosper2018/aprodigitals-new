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

class UserController extends Controller
{

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
        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
                'position_id' => ['required'],
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'mobile_phone' => ['required', 'numeric', 'min:0', 'unique:users'],
            ],
            // [
            //     'username.required' => 'The :attribute field is required.',
            //     'password.required' => 'The :attribute field is required.',
            //     'password.min' => 'The :attribute must be at least :min characters.',
            //     'password.regex' => 'The :attribute must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            //     'mobile_phone.required' => 'The :attribute field is required.',
            //     'mobile_phone.unique' => 'The :attribute is already taken.',
            // ]
        );
        // dd($validator->errors());
        if ($validator->fails()) {
            return redirect()->route('user.form')->withErrors($validator->errors());
        }
        // dd($validator);


        $verificationToken = Str::random(60); // Generate a random 60-character string

        $data = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'position_id' => $request->position_id,
            // 'position_name',
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'mobile_phone' => $request->mobile_phone,
            'passchg_logon' => isset($request->passchg_logon) ? 1 : 0,
            'user_locked' => isset($request->user_locked) ? 1 : 0,
            'day_1' => isset($request->day_1) ? 1 : 0,
            'day_2' => isset($request->day_1) ? 1 : 0,
            'day_3' => isset($request->day_1) ? 1 : 0,
            'day_4' => isset($request->day_1) ? 1 : 0,
            'day_5' => isset($request->day_1) ? 1 : 0,
            'day_6' => isset($request->day_1) ? 1 : 0,
            'day_7' => isset($request->day_1) ? 1 : 0,
            'staff_id' => $request->staff_id,
            // 'posted_user',
            'posted_ip' => $request->ip(),
            'gender' => $request->gender,
            'verification_token' => $verificationToken,
        ];

        $send = User::create($data);

        return redirect()->route('user.register')->with('message', 'User added successfully!');
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


    public function viewall(Request $request)
    {
        $data = DB::table('users')->leftJoin('positions', 'users.position_id', '=', 'positions.position_id')
            ->select(['positions.position_name', 'users.id', 'users.username', 'users.firstname', 'users.lastname', 'users.mobile_phone', 'users.email', 'users.pin_missed', 'users.login_status', 'users.created_at']);

        if ($request->ajax()) {

            return datatables()->of($data)->toJson();
        }
        return view('user.view');
    }


    public function show(User $user)
    {
        //
    }


    public function edit(User $user)
    {
        //
    }


    public function update(Request $request, User $user)
    {
        //
    }


    public function destroy(User $user)
    {
        //
    }
}
