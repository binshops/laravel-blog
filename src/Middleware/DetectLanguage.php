<?php


namespace BinshopsBlog\Middleware;

use Closure;
use BinshopsBlog\Models\BinshopsLanguage;

class DetectLanguage
{
    public function handle($request, Closure $next)
    {
        $lang = BinshopsLanguage::where('locale', $request->route('locale'))
            ->where('active', true)
            ->first();

        if (!$lang){
            return abort(404);
        }
        $request->attributes->add(['lang_id' => $lang->id, 'locale' => $lang->locale]);

        return $next($request);
    }
}
