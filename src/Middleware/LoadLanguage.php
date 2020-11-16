<?php


namespace HessamCMS\Middleware;
use Closure;
use HessamCMS\Models\HessamLanguage;

class LoadLanguage
{

    public function handle($request, Closure $next)
    {
        $lang = HessamLanguage::where('locale', config("hessamcms.default_language"))
            ->first();

        $request->attributes->add(['locale' => $lang->locale]);

        $response = $next($request);
        $response->withCookie(cookie()->forever('language_id', $lang->language_id));
        return $response;
    }
}
