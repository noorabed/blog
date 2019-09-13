<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\User;
use App\Comment;
use DB;



class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $limit =10;
    public function index()
    {

        $comments=Comment::orderBy('id','desc')
            ->simplePaginate($this->limit);
        return view('post.comments',compact('comments'));
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
    public function store(Blog $post,Request $request)
    {

        //$data = $request->all();
      //  $data['blog_id']= $post->id;
       //Comment::create($data);
        $setting = \App\Setting::first();
        if($setting->comment==0) {
            abort(404);
        }
            $post->comments()->create($request->all());
       return redirect()->back()->with('message',"Your comments Successfully send.");
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
        $comments = Comment::findOrFail($id);
        $comments->delete();
        Action::addToLog(' delete comments ');
        return redirect('/comments')->with('success', 'Comment is successfully deleted');
    }

    }
