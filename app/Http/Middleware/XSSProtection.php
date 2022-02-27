<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->input();

        array_walk_recursive($input, function (&$input, $key) {
            $input = filter_var($input, FILTER_SANITIZE_STRING);
        });
        $request->merge($input);
        return $next($request);
    }
}
