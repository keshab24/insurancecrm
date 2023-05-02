<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Agent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $categ)
    {

        $companyID = count(Auth::user()->userAgents) ? Auth::user()->userAgents->pluck('company_id') : '';
//    dd($companyID);
        if ($companyID) {
            $cat = DB::table('company')->whereIn('id', $companyID)->pluck('type');
            $cat = $cat->toArray();
        } else {
            $cat = array('all');
        }
        if (in_array('NonLife',$cat) || in_array('all',$cat)) {
            return $next($request);
        }
        return response()->view('layouts.backend.denied');
    }
}
