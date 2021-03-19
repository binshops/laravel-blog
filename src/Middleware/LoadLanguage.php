<?php


namespace BinshopsBlog\Middleware;
use Closure;
use BinshopsBlog\Models\BinshopsConfiguration;
use BinshopsBlog\Models\BinshopsLanguage;

class LoadLanguage
{

    public function handle($request, Closure $next)
    {
        $default_locale = BinshopsConfiguration::get('DEFAULT_LANGUAGE_LOCALE');
        $lang = BinshopsLanguage::where('locale', $default_locale)
            ->first();

        $request->attributes->add([
            'locale' => $lang->locale,
            'language_id' => $lang->id
        ]);

        return $next($request);
    }
}
