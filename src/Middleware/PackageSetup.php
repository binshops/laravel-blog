<?php


namespace WebDevEtc\BlogEtc\Middleware;

use Closure;
use WebDevEtc\BlogEtc\Models\HessamConfiguration;
use WebDevEtc\BlogEtc\Models\HessamLanguage;

class PackageSetup
{
    public function handle($request, Closure $next)
    {
        $initial_setup = HessamConfiguration::get('INITIAL_SETUP');
        if (!$initial_setup){
            HessamConfiguration::set('INITIAL_SETUP', true);

            return redirect( route('blogetc.admin.setup') );
        }

        if(!$initial_setup->value){
            return redirect( route('blogetc.admin.setup') );
        }

        return $next($request);
    }
}
