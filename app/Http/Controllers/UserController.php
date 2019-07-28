<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Support\Facades\Input;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            return datatables()->of(User::latest()->get())
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="state" id="'.$data->id.'" class="state btn btn-danger btn-sm">Change State</button>';
                    $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('layouts.view');
        /**$users =User::all();

        return view('layouts.index', compact('users'));*/

    }
    public function create()
    {
        $users =User::all();
        return view('layouts.adduser',compact('users'));
    }
    public function view()
    {
        $users =User::paginate(1);
        return view('layouts.view',compact('users'));
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' =>  'required',
            'user_photo' =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request['password']);
        if(!$request->state){
            $user->state =false;
        }
        $image = $request->file('user_photo');

        $profileName = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('image'), $profileName);;
        $user-> user_photo= $profileName;


        $user->save();

        // $user = User::create($validated);
        return redirect('/view')->with('success', 'User is successfully saved');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('layouts.edituser', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($request->hasFile('user_photo')){
            $file=$request->file('user_photo');
            $extension=$file->getClientOriginalExtension();
            $filename= time().'.'.$extension;
            $file->move(public_path('image'), $filename);
            $user-> user_photo= $filename;
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            //'password' => bcrypt($request->password),
            'user_photo' => $request->$filename,
        ]);
        return redirect('/view')->with('success', 'User is successfully updated');
    }

    public function destroy($id)
    {
        /// dd($id);
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/view')->with('success', ' User is successfully deleted');
    }
    public function changestate($id)
    {
        // dd($id);
        $user = User::findOrFail($id);

        if( $user->state == false){
            // dd('cond');
            $user->update(['state' => true]);
        }
        else{

            $user->update(['state' => false]);
            // dd('else',$user);
        }
        // $users=User::all();
        return redirect()->back();
        //return redirect()->route('users.index');


        //  return view('layouts.view', compact('users'));
        //return redirect('/view')->with('success', ' User is successfully change state');
    }
}