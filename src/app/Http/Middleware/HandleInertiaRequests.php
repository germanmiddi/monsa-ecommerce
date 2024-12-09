<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        
        $is_admin = Auth::user() && Auth::user()->role->name == 'admin';

        if($is_admin && env('SHOW_MODULE_STORE')){
            $show_module_store = true;
        }else{
            $show_module_store = false;
        }

        $groups = [];
        if (Auth::check()) {
            $groups = session('userGroups');
        }
        

        return array_merge(parent::share($request), [
            'userGroups' => $groups,
            'show_module_store' => $show_module_store,
        ]);        
    }
}
