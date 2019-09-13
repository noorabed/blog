<?php

namespace App\Http\Controllers;

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

            if(!Gate::allows('isAdmin')){
                abort(404);
            }
        $user=auth()->user();

        $categories = Category::all();
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

        return view('category.categorylist', compact('categories'));

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
        $category->title = $request->get('title');
        $category->slug = $request->get('slug');
        //$category->user()->associate(auth()->id());
        $category->save();
        \Action::addToLog('search for add category ');

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
        $validated = $request->validate([
            'title' => 'required',
            'slug' => 'required',
        ]);
       // dd($request->all());
        Category::whereId($request->hidden_id)->update($validated);
        \Action::addToLog('search for update category ');

        return response()->json(['success' => 'Category is successfully updated']);
    }
    public function destroy($id)
    {
        $data = Category::find($id);
        $data->delete();
        \Action::addToLog('search for delete category ');

    }


    function test( User $user){
        $user_role = Role::find($user->role_id);
        $role_permissions = $user_role->permissions;
        foreach ($role_permissions as $permission) {
            if ($permission->id ==6) {
                return true;
            }
        }
        return false;
    }
}
