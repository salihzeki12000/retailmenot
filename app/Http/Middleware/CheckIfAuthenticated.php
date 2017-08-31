<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/17/2017
 * Time: 11:55 AM
 */

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        return $next($request);
    }

}