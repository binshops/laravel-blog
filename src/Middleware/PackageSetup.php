<?php


namespace HessamCMS\Middleware;

use Closure;
use HessamCMS\Models\HessamConfiguration;
use HessamCMS\Models\HessamLanguage;

class PackageSetup
{
    public function handle($request, Closure $next)
    {
        $initial_setup = HessamConfiguration::get('INITIAL_SETUP');
        if (!$initial_setup){
            HessamConfiguration::set('INITIAL_SETUP', true);

            return redirect( route('hessamcms.admin.setup') );
        }

        if(!$initial_setup->value){
            return redirect( route('hessamcms.admin.setup') );
        }

        return $next($request);
    }
}
