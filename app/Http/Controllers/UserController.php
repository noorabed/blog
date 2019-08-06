<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Support\Facades\Input;
use App\User;
use Validator;
class UserController extends Controller
{
    public function index()
    {

        /**$users =User::all();

        return view('user.index', compact('users'));*/

    }
    public function create()
    {
        /**$users =User::all();
        return view('user.adduser',compact('users'));*/
    }
    public function view()
    {
        $users =User::all();
        if(request()->ajax())
        {
            return datatables()->of(User::latest()->get())
                ->addColumn('action', function($data){
                   // $button = ' <input type="checkbox" name="state" data-id="'.$data->id.'" onclick="static(this)" class="toggle-class" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" />';
                    $button = '<button type="button" name="state" data-id="'.$data->id.'" onclick="static(this)" class="state btn btn-default btn-sm">Change State</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('user.view',compact('users'));
       /** $users =User::paginate(1);
        return view('user.view',compact('users'));*/
    }
    public function store(Request $request)
    {
//dd($request->all());
        $rules = array(
            'name' => 'required',
            'email' => 'required',
            'password' =>  'required',
            'user_photo'=>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('user_photo');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('image'), $new_name);


        $form_data = array(
            'name'        =>  $request->name,
            'email'         =>  $request->email,
            'password' => bcrypt($request->password),
            'user_photo' =>  $new_name
        );
            //dd($form_data);
       User::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
        /**
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
        return redirect('/view')->with('success', 'User is successfully saved');*/
    }
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = User::findOrFail($id);
            return response()->json(['data' => $data]);}
       /** $user = User::findOrFail($id);

        return view('user.edituser', compact('user'));*/
    }
    public function update(Request $request)
    {
        $image_name = $request->hidden_image;
        $image = $request->file('user_photo');
        if($image != '')
        {
            $rules = array(
                'name'    =>  'required',
                'email'     =>  'required',
                'password' =>   'required',
                'user_photo'         =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
                'name'    =>  'required',
                'email'     =>  'required',
                 'password' =>  'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

        }

        $form_data = array(
            'name'      =>   $request->name,
            'email'        =>   $request->email,
            'password' => bcrypt($request->password),
            'user_photo'            =>   $image_name
        );

        User::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
        /*$user = User::findOrFail($id);
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
        return redirect('/view')->with('success', 'User is successfully updated');*/
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        /// dd($id);
       /** $user = User::findOrFail($id);
        $user->delete();
        return redirect('/view')->with('success', ' User is successfully deleted');*/
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
      $user->save();
       return response()->json(['success' => 'json Changed successfully.']);
        // $users=User::all();
        //return redirect()->back();
        //return redirect()->route('users.index');
        //  return view('user.view', compact('users'));
        //return redirect('/view')->with('success', ' User is successfully change state');
    }
}