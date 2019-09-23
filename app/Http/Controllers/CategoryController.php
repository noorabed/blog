<?php

namespace App\Http\Controllers;

use App\Action;
use App\Blog;
use App\Policies\BlogPolicy;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\User;
use Validator;
use Gate;
class CategoryController extends Controller
{

    public function index()
    {

           // if(!Gate::allows('isAdmin')){
          //      abort(404);
          //  }
        $user=auth()->user();

        $categories = Category::all();
        $allCategories = Category::pluck('title','id')->all();
        if(request()->ajax())
        {
            return datatables()->of(Category::latest()->get())
                ->addColumn('action', function($data){
                    $button = '&nbsp;&nbsp;&nbsp;&nbsp;';
                    if (\Gate::allows('blogs.editcategory')) {
                        $button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</button>';
                    }
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    if (\Gate::allows('blogs.deletecategory')) {
                        $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('category.categorylist', compact('categories','allCategories'));

    }

    public function create()
    {
       return view('category.create');
    }

    public function store(Request $request)
    {
        $rules =array(
            'title' => 'required',
            'slug' => 'required',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $category = new Category;
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category-> parent_id = empty($category['parent_id']) ? 0 : $request-> parent_id;

        //$category->user()->associate(auth()->id());
        $category->save();
       Action::addToLog('search for add category ');

        return response()->json(['success' => 'Data Added successfully.']);
       }
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Category::findOrFail($id);
            return response()->json(['data' => $data]);
        }

    }
    public function update(Request $request)
    {
        $rules = array(
            'title' => 'required',
            'slug' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'title' => $request->title,
            'slug' => $request->slug,
        'parent_id' => empty($form_data['parent_id']) ? 0 :$request-> parent_id
        );
        Category::whereId($request->hidden_id)->update($form_data);

        Action::addToLog('search for update category ');

        return response()->json(['success' => 'Category is successfully updated']);
    }
    public function destroy($id)
    {
        $data = Category::find($id);
        $data->delete();
        Action::addToLog('search for delete category ');

    }



}
