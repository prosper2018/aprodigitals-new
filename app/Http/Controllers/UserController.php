<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::all();
        return view('user.register', compact('positions'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'position_id' => ['required'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_phone' => ['required', 'int', 'min:0', 'unique:users'],
        ]);

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
