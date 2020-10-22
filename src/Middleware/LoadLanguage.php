<?php


namespace WebDevEtc\BlogEtc\Middleware;
use Closure;
use WebDevEtc\BlogEtc\Models\HessamLanguage;

class LoadLanguage
{

    public function handle($request, Closure $next)
    {
        $language_id = HessamLanguage::where('locale',config("blogetc.default_language"))->first()->id;

        $response = $next($request);
        $response->withCookie(cookie()->forever('language_id', $language_id));
        return $response;
    }
}
