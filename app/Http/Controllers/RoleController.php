<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Role;
use App\Permission;
use Validator;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            return datatables()->of(Role::latest()->get())
                ->addColumn('action', function($data){
                    $button = '<a href="'. route('roles.edit',$data->id) .'" name="edit" id="'.$data->id.'" class="edit btn btn-default"><i class="fa fa-edit"></i> Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('user.role',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions=Permission::all();
        $roles = Role::all();
        return view('user.addrole',compact('roles','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =array(
            'name' => 'required|unique:roles',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $roles = new Role;
        $roles->name = $request->get('name');
        $roles->save();
        $roles->permissions()->sync($request->permission);

        return redirect('/roles')->with('success', 'Blog Added successfully.');
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
        $permissions=Permission::all();
        $roles = Role::findOrFail($id);
        return view('user.editrole',compact('roles','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //return $request->all();
        $rules =array(
            'name' => 'required|unique:roles',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

      // dd($request->all());
        $roles = Role::findOrFail($id);
        $roles->name = $request->get('name');
        $roles->save();
        $roles->permissions()->sync($request->permission);

        return redirect('/roles');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Role::findOrFail($id);
        $data->delete();
    }
}
