<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\Datatables;

use App\Http\Controllers\CategoriesController;

class BlogPostController extends Controller
{

  
    public function index()
    {
        if (auth()->user()) {
            $categories = Categories::all();
            $posts = BlogPost::paginate(5); //fetch all blog posts from DB
            return view('blog.index', [
                'posts' => $posts,
                'categories' => $categories,
            ]); //returns the view with posts
        }
        $categories = Categories::all(); //fetch all blog posts from DB
        $posts = BlogPost::paginate(5); //fetch all blog posts from DB
        return view('blog.index', [
            'posts' => $posts, 'categories' => $categories,
        ]); //returns the view with posts
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view()
    {
        $categories = Categories::all();
        return view('blog.view', ['categories' => $categories]);
    }


    public function viewall(Request $request)
    {
        $data = DB::table('blog_posts')->leftJoin('categories', 'categories.id', '=', 'blog_posts.post_category_id')
            ->leftJoin('users', 'users.id', '=', 'blog_posts.author_id')->select(['blog_posts.id', 'blog_posts.title', 'blog_posts.created_at', 'blog_posts.post_image', 'blog_posts.post_tags', 'blog_posts.post_comment_count', 'blog_posts.post_status', 'blog_posts.post_views_count', 'categories.cat_title', DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS name")]);

        if ($request->ajax()) {

            return datatables()->of($data)->toJson();
        }
        return view('blog.view');
    }

 
    public function create()
    {
        $categories = Categories::all();
        return view('blog.create', ['categories' => $categories,]);
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'post_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->post_image->extension();

        $request->post_image->move(public_path('images'), $imageName);

        $newPost = BlogPost::create([
            'title' => $request->post_title,
            'post_category_id' => $request->post_category_id,
            // 'author_id' => $request->author_id,
            'post_author' => $request->post_author,
            'post_content_excerpt' => $request->post_content_excerpt,
            'page_1' => $request->page_1,
            'page_2' => $request->page_2,
            'post_tags' => $request->post_tags,
            'post_image' => $imageName,
            // 'post_comment_count' => $request->post_comment_count,
            'post_status' => $request->post_status,
            // 'author_id' => 1
            'author_id' => auth()->user()->id
        ]);

        return redirect('/blog/' . $newPost->id . "/page_1");
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
            if ($action == 'published' || $action == 'draft') {
                $update = BlogPost::where('id', $id[$i])->update([
                    'post_status' => $action
                ]);
                if ($update > 0) {
                    $count++;
                }
            } elseif ($action == 'reset_view_count') {
                $update = BlogPost::where('id', $id[$i])->update([
                    'post_views_count' => 0
                ]);
                if ($update > 0) {
                    $count++;
                }
            } elseif ($action == 'delete') {
                $delete = BlogPost::where('id', $id[$i])->delete();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postViews(Request $request)
    {
        $id = $request->id;
        $update = BlogPost::find($id)->increment('post_views_count');

        if ($update > 0) {
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_by_category(BlogPost $blogPost)
    {
        $count = DB::table("blog_posts")->where("post_category_id", $blogPost->id)->get('id');
        $posts = DB::table("blog_posts")->where("post_category_id", $blogPost->id)->paginate(5);
        $count_value = count($count);
        $categories = Categories::all();
        if (auth()->user()) {
            return view('blog.index', [
                'posts' => $posts, 'categories' => $categories, 'count' => $count_value
            ]);
        }
        return view('blog.index', [
            'posts' => $posts, 'categories' => $categories, 'count' => $count_value
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $blogPost, $page)
    {
        $coulumn = "page_" . $page;
        $pages = DB::table("blog_posts")->where("id", $blogPost->id)->value($coulumn);

        $categories = Categories::all();
        if (auth()->user()) {
            return view('blog.show', [
                'post' => $blogPost,
                'categories' => $categories,
                'page' => $pages,
                'page_id' => $page,
            ]); //returns the view with the post
        }
        return view('blog.show', [
            'post' => $blogPost,
            'categories' => $categories,
            'page' => $pages,
            'page_id' => $page,
        ]); //returns the view with the post
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPost $blogPost)
    {

        $categories = Categories::all();
        return view('blog.edit', [
            'post' => $blogPost,
            'categories' => $categories,
        ]); //returns the edit view with the post
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        //

        $post = blogPost::find($request->post_id);
        if ($request->has('post_image')) {
            $request->validate([
                'post_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $request->post_image->extension();

            $request->post_image->move(public_path('images'), $imageName);
        } else {
            $imageName = $post->post_image;
        }

        $update = $post->update([
            'title' => $request->post_title,
            'post_category_id' => $request->post_category_id,
            'post_author' => $request->post_author,
            'post_content_excerpt' => $request->post_content_excerpt,
            'page_1' => $request->page_1,
            'page_2' => $request->page_2,
            'post_tags' => $request->post_tags,
            'post_image' => $imageName,
            'post_status' => $request->post_status
        ]);

        if ($update > 0) {
            return redirect('blog/' . $request->post_id . '/edit')->with('message', 'Blog post updated successfully!');
        } else {
            return redirect('blog/' . $request->post_id . '/edit')->with('error', 'Blog post could not be updated at the momment!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect('/admin/blog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        $delete = BlogPost::where('id', $id)->delete();

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

    public function getPages(BlogPost $blogPost, $page)
    {
        return view("blog.show", [
            'post' => $blogPost,
            'page' => "page_" . $page,
        ]);
    }
}
