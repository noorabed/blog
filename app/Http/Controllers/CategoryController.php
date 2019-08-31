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

        return response()->json(['success' => 'Category is successfully updated']);
    }
    public function destroy($id)
    {
        $data = Category::find($id);
        $data->delete();

    }
}
