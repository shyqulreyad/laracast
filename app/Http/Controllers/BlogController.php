<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return Blog::all();
    }

        // send all user list to the api
        public function users()
        {
            $users = User::all();
            return response()->json([
                'status' => 'success',
                'users' => $users,
            ]);
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validate Request
        $request->validate([
            'author' =>'required',
            'title' =>'required',
            'body' =>'required',
		]);
        $blog = new Blog;
        $blog->author_name = Auth::user()->name;
        $blog->author = $request->author;
        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->save();
        return response()->json([
            "status"=> 200,
            "message" => "Blog Post Created Succesfully"
        ]);
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
    public function edit(Request $request,$id)
    {

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
        
        //validate Request
        $request->validate([
            'author' =>'required',
            'title' =>'required',
            'body' =>'required',
            ]);
            //update blog post
            $blog = Blog::find($id);
            $blog->author = $request->author;
            $blog->title = $request->title;
            $blog->body = $request->body;
            $blog->save();
            return response()->json([
                "status"=> 200,
                "message" => "Blog Post Updated Succesfully"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete blog post
        $blog = Blog::find($id);
        $blog->delete();
        return response()->json([
            "status"=> 200,
            "message" => "Blog Post Deleted Succesfully"
        ]);
    }

    //increment blog post like
    public function like($id)
    {
        $blog = Blog::find($id);
        $blog->likes = $blog->likes + 1;
        $blog->save();
        return response()->json([
            "status"=> 200,
            "message" => "Blog Post Liked Succesfully"
        ]);
    }

    //decrement blog post like
    public function unlike($id)
    {
        $blog = Blog::find($id);
        $blog->likes = $blog->likes - 1;
        $blog->save();
        return response()->json([
            "status"=> 200,
            "message" => "Blog Post Disliked Succesfully"
        ]);
    }

    //increment blog post dislike
    public function dislike($id)
    {
        $blog = Blog::find($id);
        $blog->dislikes = $blog->dislikes + 1;
        $blog->save();
        return response()->json([
            "status"=> 200,
            "message" => "Blog Post Disliked Succesfully"
        ]);
    }

    //decrement blog post dislike
    public function undislike($id)
    {
        $blog = Blog::find($id);
        $blog->dislikes = $blog->dislikes - 1;
        $blog->save();
        return response()->json([
            "status"=> 200,
            "message" => "Blog Post Undisliked Succesfully"
        ]);
    }

    //sending user blog post list
    public function userblog()
    {
        $id = Auth::user()->id;
        $blog = Blog::where('author',$id)->get();
        return response()->json([
            "status"=> 200,
            "message" => "Blog Post List",
            "data" => $blog
        ]);
    }

    //sending user blog post list
    public function singleuserblog($id)
    {
        $blog = Blog::where('author',$id)->get();
        return response()->json([
            "status"=> 200,
            "message" => "Blog Post List",
            "data" => $blog
        ]);
    }
}
