<?php

namespace Yormy\ChaskiLaravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class ValidateSignature
{
    private $keyResolver;

    public function __construct()
    {
        $this->keyResolver = function () {
            return App::make('config')->get('app.key');
        };
    }

    /**
     * Based in/laravel/framework/src/Illuminate/Routing/Middleware/ValidateSignature.php.
     * Handle an incoming request.
     *
     * @param  IlluminateHttpRequest  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->hasValidSignature($request)) {
            return $next($request);
        }
        throw new InvalidSignatureException;
    }

    /**
     * Determine if the given request has a valid signature.
     * copied and modified from
     * vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php:363
     *
     * @param  bool  $absolute
     * @return bool
     */
    public function hasValidSignature(Request $request, $absolute = true)
    {
        $url = $absolute ? $request->url() : '/'.$request->path();

        // THE FIX for reverse proxy
        $url = str_replace('http://', 'https://', $url);

        $original = rtrim($url.'?'.Arr::query(
            Arr::except($request->query(), 'signature')
        ), '?');

        $expires = $request->query('expires');

        $signature = hash_hmac('sha256', $original, call_user_func($this->keyResolver));

        return hash_equals($signature, (string) $request->query('signature', '')) &&
            ! ($expires && Carbon::now()->getTimestamp() > $expires);
    }
}
