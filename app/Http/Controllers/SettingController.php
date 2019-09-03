<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ Setting ;
use Validator;
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::first();
        return view('user.settings',compact('settings'));
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
        $rules = array(
            'website' => 'required',
            'facebook_link' => 'required',
            'youtube_link' => 'required',
            'twitter_link' => 'required',
            'address' => 'required',
          'mobile'=> 'required',
            'logo'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('logo');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('image'), $new_name);

        $form_data = array(
            'website'        =>  $request->website,
            'facebook-link'         =>  $request->facebook_link,
            'youtube-link' => $request->youtube_link,
            'twitter-link'          =>$request->twitter_link,
            'address'          =>$request->address,
            'mobile'          =>$request->mobile,
            'logo' =>  $new_name
        );
   //   dd($form_data);
        Setting::create($form_data);
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
        $settings = Setting::find($id);
        return view('user.settings', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {



        $image_name = $request->hidden_image;
        $image = $request->file('logo');
        if($image != '')
        {
            $rules = array(
                'website' => 'required',
                'facebook_link' => 'required',
                'youtube_link' => 'required',
                'twitter_link' => 'required',
                'address' => 'required',
                'mobile'=> 'required',
                'logo'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                'website' => 'required',
                'facebook_link' => 'required',
                'youtube_link' => 'required',
                'twitter_link' => 'required',
                'address' => 'required',
                'mobile'=> 'required',
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

        }
        $registers = $request->register;

        if ($registers == true) {
            $registers= false;
        }
        else{
            $registers= true;
        }
        $comments = $request->comment;

        if ($comments == true) {
            $comments= false;
        }
        else{
            $comments= true;
        }

        $form_data = array(
            'website'        =>  $request->website,
            'facebook-link'         =>  $request->facebook_link,
            'youtube-link' => $request->youtube_link,
            'twitter-link'          =>$request->twitter_link,
            'address'          =>$request->address,
            'mobile'          =>$request->mobile,
            'logo' =>  $image_name,
            'register' =>  $registers,
            'comment' =>  $comments,
        );

         // dd($form_data);
    Setting::whereId($id)->update($form_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
