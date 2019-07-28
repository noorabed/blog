<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(1);

        return view('category.categorylist', compact('categories'));

    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->title = $request->get('title');
        //$category->user_id = $request->get('user_id');
        $category->user()->associate(auth()->id());
        $category->save();
        return redirect('/category/categorylist')->with('success', 'Category Added successfully.');
        // return 'Success';
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('category.editcategory', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);
        Category::whereId($id)->update($validated);
        return redirect('/category/categorylist')->with('success', 'Category is successfully updated');
    }
    public function destroy($id)
    {
        //dd($id);
        $category = Category::find($id);
        $category->delete();
        return redirect('/category/categorylist')->with('success', 'Category deleted  successfully.');

    }
}
