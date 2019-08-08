<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Blog;
use App\User;
use App\Category;
use DB;
use Validator;
use Redirect;

class BlogController extends Controller
{


   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $categories = Category::all();
        if(request()->ajax())
        {
            return datatables()->of(Blog::latest()->get())
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;

                }) ->addColumn('post_descripition', function($data){
                    $string_limit= str_limit($data->post_descripition,100);
                   return $string_limit ;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('post.index',compact('categories'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request)
    {
        //dd($request->all());
        $rules = array(
            'post_tittle'    =>  'required',
            'post_descripition'     =>  'required',
            'post_photo'         =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('post_photo');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('image'), $new_name);
               $form_data = array(
            'post_tittle'        =>  $request->post_tittle,
            'post_descripition'         =>  $request->post_descripition,
            'post_photo'             =>  $new_name,
            'user_id'   =>auth()->id(),
             'view_count'        => rand(1,10)*10,
              'category_id'        =>$request->category,
        );
        //dd($form_data);

        $create= Blog::create($form_data);
        //$category = Category::all();
        //$create->categories()->attach($category);
        session()->flash('suceess', 'Task was successful!');

        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Blog::find($id);
            return response()->json(['data' => $data]);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      // dd($request->all());
        $image_name = $request->hidden_image;
        $image = $request->file('post_photo');
        if($image != '')
        {
            $rules = array(
                'post_tittle'    =>  'required',
                'post_descripition'     =>  'required',
                'post_photo'         =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image'), $image_name);
        }
        else
        {
            $rules = array(
                'post_tittle'    =>  'required',
                'post_descripition'     =>  'required'
        );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

        }

        $form_data = array(
            'post_tittle'      =>   $request->post_tittle,
            'post_descripition'        =>   $request->post_descripition,
            'post_photo'            =>   $image_name
        );

        Blog::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);

    }

     public function show(){
        $categories = Category::with('posts')
            ->orderBy('title','asc')
            ->get();

        $blogs=Blog::with('user')
            ->latest()
            ->get();

        return view('blog.index',compact('blogs', 'categories'));
    }

        public function view($id){

        $categories = Category::orderBy('title','asc') ->get();
        $blogs=Blog::findOrFail($id);

        return view('blog.show',compact('blogs', 'categories'));
    }

    public function category($id){
        $categories = Category::with('posts')
            ->orderBy('title','asc')
            ->get();

        $blogs=Blog::with('user')
            ->latest()
            ->where('category_id',$id)
            ->get();
        //dd($blogs,$categories);
        return view('blog.index',compact('blogs', 'categories'));}

   /** public function popular(){

        $blogs=Blog::orderBy('view_count')->get();

        return view('blog.show',compact('blogs'));
    }*/
    
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Blog::findOrFail($id);
        $data->delete();
    }
}
