<?php

namespace App\Http\Controllers;

use App\permission;
use Validator;
use Illuminate\Http\Request;

class PermissionController extends Controller
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
            return datatables()->of(Permission::latest()->get())
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }



        return view('user.permission',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|unique:permissions',
            'for' => 'required',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $permissions = new Permission;
        $permissions->name = $request->get('name');
        $permissions->for = $request->get('for');
        $permissions->save();


        return response()->json(['success' => 'Data Added successfully.']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Permission::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        // dd($request->all());
        Permission::whereId($request->hidden_id)->update($validated);

        return response()->json(['success' => 'Category is successfully updated']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(permission $permission,$id)
    {
        $data = Permission::findOrFail($id);
        $data->delete();
    }
}
