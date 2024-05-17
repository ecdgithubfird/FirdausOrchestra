<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\IPWhitelist\Models\IPWhitelist;
use Modules\IPFilter\Models\IPFilter;
class WhitelistIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $whitelist_ip = IPWhitelist::all();
        $blacklist_ip = IPFilter::all();
        $allowedIp = array();
        $deniedIp = array();

        $clientIP = $request->ip();     
        
        if ($clientIP === null) {
            
            return response('Invalid IP.', 400);
        }
        foreach($whitelist_ip as $ip)
        {
            $allowedIp[] = $ip->ip_address;
        }
        foreach ($blacklist_ip as $ip) {
            $deniedIp[] = $ip->ip_address;
        }

        if (in_array($clientIP, $allowedIp)) {
            // IP is whitelisted, allow the request to proceed
            return $next($request);
        }
        if (in_array($clientIP, $deniedIp)) {
            // IP is blacklisted, reject the request
           
            return response('Unauthorized.', 401);
        }
        
        // If not whitelisted or blacklisted, continue with the request
        return $next($request);
        
        
    }
}
