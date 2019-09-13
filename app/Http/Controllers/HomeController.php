<?php

namespace App\Http\Controllers;
use Location;
use Jenssegers\Agent\Agent;
use GeoIP;
use App\Http\Controllers\App\Action;
use App\Vistor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Blog;
use App\User;
use App\Category;
use App\Comment;
use App\Tag;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //$position = Location::get(ip_addres);
        //$device=get_browser( $request->header('User-Agent') , true);
       // dd($position);
        $blogs = Blog::all();
        $user = User::all();
        $comments = Comment::all();
        $vistors =Vistor::all();
      //  $categories = Category::all();
        $date = \Carbon\Carbon::today()->subDays(30);
       $popular_post=Blog::withCount('comments')
            ->withCount('user')
            ->orderBy('view_count','desc')
            ->orderBy('user_count','desc')
            ->orderBy('comments_count','desc')
           -> where('created_at', '>=', $date)
            ->take(5)
            ->get();
        $all_view=Blog::sum('view_count');
      // dd(\App\Blog::withCount('user')->get());
       // $date = \Carbon\Carbon::today()->subDays(30);
        $active_user=User::withCount('comments')
            ->withCount('blogs')
            ->orderBy('blogs_count','desc')
            ->orderBy('comments_count','desc')
            -> where('created_at', '>=', $date)
            ->get();
//dd($active_user);



     $vistor = new Vistor();
        $agent = new Agent();
        $ip = \Request::ip();
        $geo = GeoIP::getLocation($ip);
        $country = $geo['country'];
     $vistor-> user_id = auth()->id();
     $vistor-> ip = $ip;
     $vistor-> country =$country ;
     $vistor->browser =$agent->browser();
     $vistor->device = $agent->device();
 //dd($vistor);
        $vistor->save();


        $categories=Category::with('posts')->get();
       // dd($categories);
        $array[]=['Title','Number'];
        foreach ($categories as  $value) {
            $array[] = [$value->title, count($value->posts)];
        }
           //dd($array);

        $tags=Tag::with('blogs')->get();
       // dd($tags);
        $tag[]=['Name','Number'];
        foreach ($tags as  $value) {
            $tag[] = [$value->name, count($value->blogs)];
        }
    //   dd($tag);
        return view('home',compact('blogs','user','all_view','popular_post','active_user','date','categories','vistor'))
            ->with('title', json_encode($array))
            ->with('name', json_encode($tag)) ;

    }

}
