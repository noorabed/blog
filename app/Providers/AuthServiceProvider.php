<?php

namespace App\Providers;
use App\User;
use App\Blog;
use App\Policies\BlogPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

     'App\Model' => 'App\Policies\ModelPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        Gate::resource('blogs','App\Policies\BlogPolicy') ;
        Gate::define('blogs.category','App\Policies\BlogPolicy@category') ;
        Gate::define('blogs.editcategory','App\Policies\BlogPolicy@editcategory') ;
        Gate::define('blogs.deletecategory','App\Policies\BlogPolicy@deletecategory') ;
        Gate::define('blogs.deletetag','App\Policies\BlogPolicy@deletetag') ;

        Gate::define('users.create','App\Policies\UserPolicy@create') ;
        Gate::define('users.update','App\Policies\UserPolicy@update') ;
        Gate::define('users.delete','App\Policies\UserPolicy@delete') ;
        Gate::define('users.updatesetting','App\Policies\UserPolicy@updatesetting') ;


        $gate->define('isAdmin', function($user){
            return $user->id == '1' ;
        });


    }
}
