<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Gestionnaire
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       // dd(Auth::user());
       // if(auth()->user()->role=='gestionnaire' ){
            return $next($request);

        //}
        //return redirect()->route('home')->with('error','Vous n\'êtes pas autorisé');

    }
}
