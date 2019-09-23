<?php

namespace App\Http\Controllers;

use App\Action;
use Illuminate\Http\Request;
use App\Blog;
use App\User;
use App\Mail\reply;
use Validator;
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
        if(request()->ajax())
        {
            return datatables()->of(Comment::latest()->get())
                ->addColumn('action', function($data){
                    $button = '<a href="'. route('send.index') .'" name="send" id="'.$data->id.'" class="send btn btn-default">Send</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
    public function store(Blog $post, Request $request)
    {

        //$data = $request->all();
      //  $data['blog_id']= $post->id;
       //Comment::create($data);
        $setting = \App\Setting::first();
        if($setting->comment==0) {
            abort(404);
        }
        $rules =array(
            'user_name' => 'required',
            'user_email' => 'required',
            'user_url'=>'required',
            'comment'=>'required',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $input =$request->all();
        $input['parent_id'] = $request->parent_id ?$request->parent_id:0;
        $post->comments()->create($input);
       // dd($input);
        Action::addToLog(' add comment ');

        return response()->json(['success' => 'Data Added successfully.']);
      // return redirect()->back()->with('message',"Your comments Successfully send.");
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
        return view('emails.send_email');
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
        $data = Comment::findOrFail($id);
        $data->delete();
        Action::addToLog(' delete comments ');
        /**$comments = Comment::findOrFail($id);
        $comments->delete();
        Action::addToLog(' delete comments ');
        return redirect('/comments')->with('success', 'Comment is successfully deleted');*/
    }

    function remove(Request $request)
    {
        $id= $request->input('id');
        $comment = Comment::whereIn('id', $id);
        //dd($comment);
        if($comment->delete())
        {
            echo 'Data Deleted';
        }
       // return redirect('/comments')->with('success', 'Data Added successfully.');
    }

    }
