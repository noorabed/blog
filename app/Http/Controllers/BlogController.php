<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Blog;
use App\User;
use App\Category;
use App\Tag;
use DB;
use function Sodium\compare;
use Validator;
use Redirect;

class BlogController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $limit =3;
    public function index()
    {
        $blogs = Blog::all();
        $categories = Category::all();
        if(request()->ajax())
        {
            return datatables()->of(Blog::latest()->get())
                ->addColumn('action', function($data){
                    $button = '<a href="'. route('blogs.edit',$data->id) .'" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;

                }) ->addColumn('post_descripition', function($data){
                    $string_limit= str_limit($data->post_descripition,50);
                   return $string_limit ;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('post.index',compact('blogs','categories'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags=Tag::all();
        $categories = Category::all();
        return view('post.create',compact('blogs','categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        // $tags = explode(',',$request->post_tags);
      //  dd($tags);
        $rules = array(
            'post_tittle'        =>  'required',
            'slug'               =>  'required|unique:blogs',
            'post_descripition'  =>  'required',
            'category_id'         => 'required',
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
            'slug'               =>$request->slug,
            'excerpt'               =>$request->excerpt,
            'post_descripition'  =>  $request->post_descripition,
            'post_photo'         =>  $new_name,
            'user_id'            =>auth()->id(),
            'view_count'         => rand(1,10)*10,
            'category_id'          =>$request->category_id,
            'published_at'        =>  $request->published_at,

        );
       $create= Blog::create($form_data);
      if($create)
      {
          $tagNames = explode(',',$request->get('post_tags'));
          $tagIds = [];
          foreach($tagNames as $tagName)
          {

              $tag = Tag::firstOrCreate([
                  'name'=>$tagName,
                  'second_name'=>$tagName
              ]);
              if($tag)
              {
                  $tagIds[] = $tag->id;
              }

          }
          $create->tags()->sync($tagIds);
      }

        return redirect('/blogs')->with('success', 'Blog Added successfully.');

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

            $data = Blog::find($id);
            $categories=Category::all();
            return view('post.edit',compact('data','categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {

      //dd($request->all());
        $image_name = $request->hidden_image;
        $image = $request->file('post_photo');
        if($image != '')
        {
            $rules = array(
                'post_tittle'    =>  'required',
                'slug'               =>  'required|unique:blogs',
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
                'slug'               =>  'required|unique:blogs',
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
            'published_at'        =>  $request->published_at,
            'post_photo'            =>   $image_name,
            'slug'               =>$request->slug,
            'excerpt'               =>$request->excerpt,
        );

        $update=Blog::whereId($id)->update($form_data);

        if($update)
        {
            $tagNames = explode(',',$request->get('post_tags'));
            $tagIds = [];
            foreach($tagNames as $tagName)
            {

                $tag = Tag::where([
                    'name'=>$tagName,
                    'second_name'=>$tagName
                ]);
                if($tag)
                {
                    $tagIds[] = $tag->id;
                }

            }
            $update->tags()->sync($tagIds);
        }

        return redirect('/blogs')->with('success', 'Blog edit successfully.');


    }

     public function show(){

         $tags=Tag::all();
        $categories = Category::with('posts')
            ->orderBy('title','asc')
            ->get();

        $blogs=Blog::with('user','comments')
            ->latest()
           ->LatestFirst()->published();
        // check
        // dd($blogs);
         if ($term=request('term')){
             $blogs->where('post_tittle','LIKE',"%{$term}%");
         }
         $blogs=$blogs->simplePaginate($this->limit);


        return view('blog.index',compact('blogs', 'categories','tags'));
    }

        public function view($id){
            $tags=Tag::all();
        //$categories = Category::orderBy('title','asc') ->get();
        $blogs=Blog::findOrFail($id);
        return view('blog.show',compact('blogs', 'tags'));
    }

    public function category( Category $category){
        $tags=Tag::all();
        $categories = Category::with('posts')
            ->orderBy('title','asc')
            ->get();

        $blogs=$category->posts()
            ->with('user')
            ->latest()
            ->simplePaginate($this->limit);
         //   ->get();
        //dd($blogs,$categories);
        return view('blog.index',compact('blogs', 'categories','tags'));
    }
    public function tag(Tag $tag){
        $tags=Tag::all();
        $categories = Category::orderBy('title','asc') ->get();
        $blogs=$tag->blogs()
            ->with('user')
            ->latest()
            ->get();
        //dd($blogs,$categories);
        return view('blog.index',compact('blogs', 'tags','categories'));
    }



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

    public function gate()
    {
        $blogs = Blog::find(1);

        if (Gate::allows('update-post', $blogs)) {
            echo 'Allowed';
        } else {
            echo 'Not Allowed';
        }

        exit;
    }
}
