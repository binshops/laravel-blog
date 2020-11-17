<?php


namespace HessamCMS\Middleware;
use Closure;
use HessamCMS\Models\HessamConfiguration;
use HessamCMS\Models\HessamLanguage;

class LoadLanguage
{

    public function handle($request, Closure $next)
    {
        $default_locale = HessamConfiguration::get('DEFAULT_LANGUAGE_LOCALE');
        $lang = HessamLanguage::where('locale', $default_locale)
            ->first();

        $request->attributes->add([
            'locale' => $lang->locale,
            'language_id' => $lang->id
        ]);

        return $next($request);
    }
}
