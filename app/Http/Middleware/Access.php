<?php

namespace App\Http\Middleware;

use App\Facades\AccessFacade;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;

class Access
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $access;

    /**
     * Create a new filter instance.
     *
     * @param Guard @access
     * @return void
     */
    public function __construct(Guard $access)
    {
        $this->access = $access;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $permissions_exist = 0;
        $user_id = Auth::user()->id;
        $permission_id = DB::table('permissions')->where('name', $permission)->first();
        $role_id = Auth::user()->role_id;
        if (($permission_id != null || $permission_id != '') && ($role_id != '' || $role_id != null))
            $permissions_exist = DB::table('permission_role')->where([
                ['permission_id', '=', $permission_id->id], ['role_id', '=', $role_id]
            ])->count();
        if (isset($permissions_exist) && $permissions_exist > 0) {
            return $next($request);
        }
        return response()->view('layouts.backend.denied');
    }
}
