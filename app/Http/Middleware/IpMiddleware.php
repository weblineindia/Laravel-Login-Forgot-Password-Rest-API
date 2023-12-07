<?php

namespace App\Http\Middleware;

use Closure;
use Response;

use App\Models\Settings;

class IpMiddleware
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
        $ips = Settings::where('name','allowed_ips')->select('value')->first()->toArray();
        
        $ipList = $ips['value'];

        if($ipList != '')
        {
            $ipList = explode(",",$ipList);
            
            if (!in_array($request->ip(),$ipList)) {
                
                $this->msg['status'] = trans('messages.error');
                $this->msg['message'] = "Not Allow to Access for IP (".$request->ip().")";

                return response()->json($this->msg,400);

            }
            return $next($request);
        }
        if($ipList == '')
        {
            return $next($request);
        }   
    }
}
