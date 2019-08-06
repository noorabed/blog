<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;
use Validator;

class CategoryController extends Controller
{
    public function index()
    {
       /**$categories = Category::paginate(1);

        return view('category.categorylist', compact('categories'));*/
        $categories = Category::all();
        if(request()->ajax())
        {
            return datatables()->of(Category::latest()->get())
                ->addColumn('action', function($data){
                    $button = '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
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
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $category = new Category;
        $category->title = $request->get('title');
        $category->user()->associate(auth()->id());
        $category->save();

        return response()->json(['success' => 'Data Added successfully.']);
       // dd($request->all());

        /**$category->title = $request->get('title');
        $category->user()->associate(auth()->id());
        $category->save();

        $error = Validator::make($request->all());
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        return response()->json(['success' => 'Category Added successfully.']);*/



       /**$category = new Category;
        $category->title = $request->get('title');
        //$category->user_id = $request->get('user_id');
        $category->user()->associate(auth()->id());
        $category->save();
        return redirect('/category/categorylist')->with('success', 'Category Added successfully.');
        // return 'Success';*/
    }
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Category::findOrFail($id);
            return response()->json(['data' => $data]);
        }
       /** $category = Category::findOrFail($id);

        return view('category.editcategory', compact('category'));*/
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);
       // dd($request->all());
        Category::whereId($request->hidden_id)->update($validated);

        return response()->json(['success' => 'Category is successfully updated']);

       /** $validated = $request->validate([
            'title' => 'required',
        ]);
        Category::whereId($id)->update($validated);
        return redirect('/category/categorylist')->with('success', 'Category is successfully updated');*/
    }
    public function destroy($id)
    {
        $data = Category::find($id);
        $data->delete();
        //dd($id);
        /**$category = Category::find($id);
        $category->delete();
        return redirect('/category/categorylist')->with('success', 'Category deleted  successfully.');*/

    }
}
