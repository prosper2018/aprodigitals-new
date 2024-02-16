<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::paginate(5);
        return view('positions.index', compact('positions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.create');
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
            'position_id' => ['required', 'string', 'unique:positions'],
            'position_name' => ['required', 'string', 'max:50', 'unique:positions'],
            'position_enabled' => ['required'],
            'requires_login' => ['required']
        ]);
        Position::create([
            'position_id' => $request->position_id,
            'position_name' => $request->position_name,
            'position_enabled' => $request->position_enabled,
            'requires_login' => $request->requires_login,
            'created_at' => date("Y-m-d H:i:s"),
            'posted_user' => Auth::user()->username,
            'posted_ip' => $request->ip()
        ]);
        return redirect()->route('positions.index')->with('message', 'Role added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = DB::table('positions')->where('position_id', $id)->first();
        return view('positions.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = DB::table('positions')->where('position_id', $id)->first();
        
        $role->position_name = $request->position_name;
        $role->position_enabled = $request->position_enabled;
        $role->requires_login = $request->requires_login;
        // $role->posted_user = $request->posted_user;
        $role->posted_ip = $request->ip;
       
        DB::table('positions')->where('position_id', $id)->update([
            'position_name' => $request->position_name, 
            'position_enabled' => $request->position_enabled,
            'requires_login' => $request->requires_login,
            'updated_at' => date("Y-m-d H:i:s"),
            // 'posted_user,' => $request->posted_user,
            'posted_ip' => $request->ip()
        ]);
        return redirect()->route('positions.index')->with('message', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('positions')->where('position_id', $id)->delete();
        return redirect()->route('positions.index')->with('message', 'Role deleted successfully!');
    }

    public function getPositions($department) {
        $positions = Position::where('department_id', $department)->pluck('position_name', 'position_id');
        return response()->json($positions);
    }
}
