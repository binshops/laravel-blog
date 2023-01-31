<?php

namespace BinshopsBlog\Middleware;

use BinshopsBlog\Models\BinshopsConfiguration;
use Closure;
use BinshopsBlog\Models\BinshopsLanguage;

class DetectLanguage
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('locale');
        $routeWithoutLocale = false;

        if (!$request->route('locale')){
            $routeWithoutLocale = true;
            $locale = BinshopsConfiguration::get('DEFAULT_LANGUAGE_LOCALE');
        }

        $lang = BinshopsLanguage::where('locale', $locale)
            ->where('active', true)
            ->first();

        if (!$lang){
            return abort(404);
        }

        $request->attributes->add([
            'lang_id' => $lang->id,
            'locale' => $lang->locale,
            'routeWithoutLocale' => $routeWithoutLocale
        ]);

        return $next($request);
    }
}
