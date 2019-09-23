<?php
namespace App\Http\Controllers;
use App\Subcategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use yajra\Datatables\Datatables;
use App\Blog;
use App\User;
use App\Action;
use App\Category;
use App\Comment;
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
    public function index(Request $request)
    {

        $user = Auth::user();
        if ($user->can('blogs.view', Blog::class)) {
            $blogs = Blog::all();
            $categories = Category::all();
            if (request()->ajax()) {
       // dd($request->all(),$request->search_function_fire);
              if($request->search_function_fire ==1){
                return $this->search($request);
             }

                return datatables()->of(Blog::latest()->get())
                    ->addColumn('action', function ($data) {
                        $button = '<a href="' . route('blogs.edit', $data->id) . '" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                        $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;

                    })->addColumn('post_descripition', function ($data) {
                        $string_limit = str_limit($data->post_descripition, 50);
                        return $string_limit;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

            }
            return view('post.index', compact('blogs', 'categories'));
        } else {
            echo 'Not Authorized';
        }
        exit;
    }



        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create(){

            $user = Auth::user();
            if ($user->can('create', Blog::class)) {
                $tags = Tag::all();
                $categories = Category::all();
                return view('post.create', compact('blogs', 'categories', 'tags'));
            } else {
                echo 'Not Authorized';
            }
            exit;
        }


        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */


        public function store(Request $request){

            // $tags = explode(',',$request->post_tags);
            //  dd($tags);
         $this->validate($request,[
                'post_tittle' => 'required',
                'slug' => 'required',
                'post_descripition' => 'required',
                'category_id' => 'required',
            ]);

            $image = $request->file('post_photo');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('image'), $new_name);
            $newBlog = new Blog();
            $newBlog->post_tittle = $request->post_tittle;
            $newBlog->slug = $request->slug ;
            $newBlog->excerpt = $request->excerpt;
            $newBlog->post_descripition= $request->post_descripition;
            $newBlog->post_photo = $new_name;
            $newBlog->user_id =auth()->id();
            $newBlog->view_count =rand(1,10);
            $newBlog->category_id = $request->category_id;
            $newBlog->published_at= $request->published_at;

            $newBlog->save();
           // dd($newBlog);
          //  $create = Blog::create($form_data);
            if ($newBlog) {
                $tagNames = explode(',', $request->get('post_tags'));
                $tagIds = [];
                foreach ($tagNames as $tagName) {

                    $tag = Tag::firstOrCreate([
                        'name' => $tagName,
                        'second_name' => $tagName
                    ]);
                    if ($tag) {
                        $tagIds[] = $tag->id;
                    }

                }
                $newBlog->tags()->sync($tagIds);
            }
            Action::addToLog('create post');
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
        public function edit($id){
            $user = Auth::user();
            if ($user->can('blogs.update', Blog::class)) {
                $data = Blog::find($id);
                $categories = Category::all();
                return view('post.edit', compact('data', 'categories'));
            } else {
                echo 'Not Authorized';
            }
            exit;
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
                'slug'               =>  'required',
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
                'slug'               =>  'required',
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
            'view_count' => rand(1,10),
        );

        $update=Blog::whereId($id)->update($form_data);
        Action::addToLog('update post');
      /**  if($update)
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
*/
        return redirect('/blogs')->with('success', 'Blog edit successfully.');


    }

     public function show( Request $request){

         $tags=Tag::all();
         $comment=Comment::all();
        $categories = Category::with('posts')
            ->orderBy('title','asc')
            ->get();

        $blogs=Blog::with('user')
            ->latest()
           ->LatestFirst()->published();
        // check
       // dd($blogs);
       /**  if ($term=request('term')){
             $blogs->where('post_tittle','LIKE',"%{$term}%")
             ->get();
         }*/
         $blogs=$blogs->simplePaginate($this->limit);


        return view('blog.index',compact('blogs', 'categories','tags','comment'));
    }
    public function fetch(Request $request)
      {

            if($request->get('query'))
            {
            $query = $request->get('query');
            $data = DB::table('blogs')
                ->where('post_tittle', 'LIKE', "%{$query}%")
                ->get();

                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach($data as $row)
                {
                    $output .= '
                     <li><a  href="' . route('blogs.view',$row->id). '">'.$row->post_tittle.'</a></li>
                     ';
                }
                $output .= '</ul>';
                echo $output;
            }
    }



    public function view($id){
            $setting = \App\Setting::first();
            $tags=Tag::all();
        //$categories = Category::orderBy('title','asc') ->get();
        $blogs=Blog::findOrFail($id);

        $blogKey = 'blog_' . $blogs->id;
        if (!Session::has($blogKey)) {
            $viewCount = $blogs->view_count + 1;
            $blogs->update(['view_count' => $viewCount]);
            Session::put($blogKey, 1);
        }

       // dd($blogs->comments,$blogs->comments[0]->replies,$blogs->comments[0]->commentParent );

        return view('blog.show',compact('blogs', 'tags','setting'));
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


    public function search(Request $request){
      $blogs = DB::table('blogs')->select(['id', 'post_tittle', 'post_descripition','published_at','post_photo', 'created_at', 'updated_at']);

       return Datatables::of($blogs)
      //  return datatables()->of(Blog::latest()->get())

            ->addColumn('action', function ($data) {
                $button = '<a href="' . route('blogs.edit', $data->id) . '" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                return $button;

            })
            ->rawColumns(['action'])
            ->filter(function ($query) use ($request) {
                if ($request->has('post_tittle')) {
                    $query->where('post_tittle', 'like', "%{$request->get('post_tittle')}%");
                }
                Action::addToLog('search for post tittle');
                if ($request->has('created_at')) {
                    $query->where('created_at', 'like', "%{$request->get('created_at')}%");
                }
                Action::addToLog('search for date of post ');
               $search= $request->has('published_at');
              if($search=='published'){
               return $query->whereNotNull('published_at')
                      ->get();
                 }
              elseif($search=='Draft'){
               return $query->whereNull('published_at')
                      ->get();
                }

               Action::addToLog('search for post state ');
            })

            ->make(true);
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
       Action::addToLog('delete post');
    }


}
