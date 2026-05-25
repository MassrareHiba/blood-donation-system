<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', 'fr');
        
        if (in_array($locale, ['fr', 'ar'])) {
            App::setLocale($locale);
        }
        
        return $next($request);
    }
}