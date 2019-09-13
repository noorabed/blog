<?php

namespace App;
use Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $guarded = [];

    public static function addToLog($action)
    {
        $log = [];
        $log['action'] = $action;
        $log['browser'] = Request::header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['login']=Carbon::now()->toDateTimeString();
        $log['logout']=date('Y-m-d H:i:s');

        Action::create($log);
    }


    public static function ActionLists()
    {
        return Action::latest()->get();
    }
}
