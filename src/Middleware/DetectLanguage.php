<?php


namespace WebDevEtc\BlogEtc\Middleware;

use Closure;
use WebDevEtc\BlogEtc\Models\HessamLanguage;

class DetectLanguage
{
    public function handle($request, Closure $next)
    {
        $lang = HessamLanguage::where('locale', $request->route('locale'))
            ->where('active', true)
            ->first();

        if (!$lang){
            return abort(404);
        }
        $request->attributes->add(['lang_id' => $lang->id, 'locale' => $lang->locale]);

        return $next($request);
    }
}
