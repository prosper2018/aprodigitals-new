<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\BlogPost;
use App\Models\BusinessDetails;
use App\Models\Comments;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function index()
    {
        $categories = Categories::all();
        $blogpost = BlogPost::all();
        $comments = Comments::all();
        $users = User::all();
        return view("admin.dashboard", ['categories'=>$categories, 'posts'=>$blogpost, 'comments'=>$comments, 'users'=>$users]);
    }


    public function profile()
    {
        $user_cont = new UserController();
        $last_access = (auth()->user()->last_used == 0) ? '<span class="badge bg-danger">Never Accessed</span>' : $user_cont->formatDate(auth()->user()->last_used);
        
        $position_details = Position::select('position_name', 'position_id')->where(['position_id' => auth()->user()->position_id])->first();
        $business_details = BusinessDetails::select(['id', 'business_name'])->where(['id' => auth()->user()->business_id])->first();
        $department_details = Department::select(['id', 'display_name'])->where(['id' => auth()->user()->department_id])->first();
        
        $users = DB::table('users')->leftJoin('positions', 'users.position_id', '=', 'positions.position_id')
        ->select(['positions.position_name', 'users.*'])->where('users.id', auth()->user()->id)->first();
        
        return view("profile", ['users'=>$users, 'position_details' => $position_details, 'last_access' => $last_access, 'business_details' => $business_details, 'department_details' => $department_details]);
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
