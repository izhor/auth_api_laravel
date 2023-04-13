<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
/**
* Header Note : there are several classes where i have to use re-define the variable into a shorter one
* in order to improve readability of code
* 
*/
class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * 
     *
     */
    public function handle(Request $request, Closure $next)
    {   
        //checking if the token is valid
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            //if the token is invalid
            if ($e instanceof TokenInvalidException){

                return response()->json(['status' => 'Token is Invalid']);

                //condition when the token is expired
            }else if ($e instanceof TokenExpiredException){
                
                return response()->json(['status' => 'Token is Expired']);
                
                //condition when the token is not found
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        //redirect the response to a next destination
        return $next($request);
    }
}
