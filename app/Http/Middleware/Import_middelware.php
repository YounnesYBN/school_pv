<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Import_middelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if(session("type")){
            if(session("type") == "directeur"){
                
                return $next($request);
            }else{
                return redirect("/");
            }
        }else{
            return redirect("login");
        }
    }
}
