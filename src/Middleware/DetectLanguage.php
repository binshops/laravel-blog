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
        $noLocaleRoute = false;

        if (!$request->route('locale')){
            $noLocaleRoute = true;
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
            'noLocaleRoute' => $noLocaleRoute
        ]);

        return $next($request);
    }
}
