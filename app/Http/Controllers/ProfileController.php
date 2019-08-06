<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Profile;
class ProfileController extends Controller
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

    public function index()
    {
        $user = Auth::user();
        $pass_data_to_view['user'] = $user;
        return view('user.profile',compact('user'));
    }

    public function update(Request $request){
//dd($request->all());
       $user = Auth::user();
            $request->validate([
            'name' => 'required|max:255',
            // 'email' => 'required|email|max:255|unique:users,id,'.$user->id,
            ]);
            $user->name = $request->name;
            //$user->email = $request->email;


            if($request->password){

                /*$request->validate([
                    'password' => 'min:6|confirmed',
                ]);*/

                $user->password = bcrypt($request->password);
            }
            if($request->hasFile('user_photo')){

                /*$request->validate([

                    'user_photo' =>  'mimes:png',
                ]);*/
                //$file = $request->user_photo;
               // dd($file->getClientOriginalExtension());
                //dd(request()->user_photo->getClientOriginalExtension());
                $profileName = $user->id.'_avatar'.time().'.'.request()->user_photo->getClientOriginalExtension();

                $request->user_photo->storeAs('avatars',$profileName);
                $user->user_photo = $profileName;
            }

        $user->save();

      return view('user.profile', array('user' => Auth::user()));

        }

}