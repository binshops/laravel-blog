<?php


namespace WebDevEtc\BlogEtc\Middleware;
use Closure;
use WebDevEtc\BlogEtc\Models\HessamLanguage;

class LoadLanguage
{

    public function handle($request, Closure $next)
    {
        $lang = HessamLanguage::where('locale', config("blogetc.default_language"))
            ->first();

        $request->attributes->add(['locale' => $lang->locale]);

        $response = $next($request);
        $response->withCookie(cookie()->forever('language_id', $lang->language_id));
        return $response;
    }
}
