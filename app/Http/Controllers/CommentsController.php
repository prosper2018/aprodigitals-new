<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categories;
use Yajra\DataTables\Facades\DataTables;

class CommentsController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        return view('comments.index', ['categories' => $categories]);
    }

     
    public function viewall(Request $request)
    {
        $data = DB::table('comments')->leftJoin('blog_posts', 'blog_posts.id', '=', 'comments.comment_post_id')
            ->select(['blog_posts.title', 'comments.*']);

        if ($request->ajax()) {

            return datatables()->of($data)->toJson();
        }
        return view('comments.index');
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
        $comment = DB::table("blog_posts")->where("id", $request->comment_post_id)->get(['post_views_count', 'post_comment_count']);
        
        $newPost = Comments::create([
            'comment_post_id' => $request->comment_post_id,
            'comment_author' => $request->comment_author,
            'comment_email' => $request->comment_email,
            'comment_content' => $request->comment_content,
        ]);
        $update = BlogPost::where('id', $request->comment_post_id)->update([
            'post_views_count' => $comment[0]->post_views_count + 1,
            'post_comment_count' => $comment[0]->post_comment_count + 1
        ]);
       
        if($update > 0){
             return redirect('blog/'. $request->comment_post_id.'/page_1')->with('message', 'Comments submitted successfully!');
        }else{
            return redirect('blog/'. $request->comment_post_id.'/page_1')->with('error', 'Comments could not be submitted at the momment!');
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comments $comments)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function applyAction(Request $request)
    {
        $id_array = $request->ids;
        $id = explode(",", $id_array);

        $action = $request->action;
        $count = 0;
        for ($i = 0; $i < count($id); $i++) {
            if ($action == 'approved' || $action == 'disapproved') {
                $update = Comments::where('id', $id[$i])->update([
                    'comment_status' => $action
                ]);
                if ($update > 0) {
                    $count++;
                }
            } elseif ($action == 'delete') {
                $delete = Comments::where('id', $id[$i])->delete();
                if ($delete > 0) {
                    $count++;
                }
            }
        }

        if ($count > 0) {
            return response()->json([
                "response_code" => 0,
                "response_message" => "Action Applied to selected records successfully"
            ]);
        } else {
            return response()->json([
                "response_code" => 1,
                "response_message" => "Action could not be Applied to selected records!"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comments $comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        $delete = Comments::where('id', $id)->delete();

        if ($delete > 0) {
            return response()->json([
                "response_code" => 0,
                "response_message" => "Selected record deleted successfully"
            ]);
        } else {
            return response()->json([
                "response_code" => 1,
                "response_message" => "Action could not be Applied to selected record Prosper!"
            ]);
        }
    }
}
