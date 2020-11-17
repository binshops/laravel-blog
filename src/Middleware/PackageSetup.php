<?php


namespace HessamCMS\Middleware;

use Closure;
use HessamCMS\Models\HessamConfiguration;

class PackageSetup
{
    public function handle($request, Closure $next)
    {
        $initial_setup = HessamConfiguration::get('INITIAL_SETUP');
        if (!$initial_setup){
            return redirect( route('hessamcms.admin.setup') );
        }

        return $next($request);
    }
}
