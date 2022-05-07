<?php

namespace Mozafar\EncBuddy;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

class EncBuddyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->shouldNotEncrypt($request) || !config('encbuddy.enabled')) {
            return $next($request);
        }

        $encrypter = new Encrypter();
        if ($this->canDecrypt($request)) {
            $data = $request->getContent();
            if (! empty($data)) {
                try {
                    $decrypted = $encrypter->decryptString($data);
                } catch (DecryptException $e) {
                    $content = json_encode([
                        'message'   =>  'Can`t decrypt request content.'
                    ]);
                    return response($encrypter->encryptString($content))->setStatusCode(400);
                }
                $decoded = json_decode($decrypted, true);
                if (!is_null($decoded)) {
                    $request->replace($decoded);
                }
            }
        }

        $response = $next($request);

        if ($this->canEncrypt($request)) {
            if (!empty($response->getContent())) {
                $encrypted = $encrypter->encryptString($response->getContent());
                $response->setContent($encrypted);
            }
        }
        return $response;
    }

    private function canDecrypt(Request $request)
    {
        return !config('app.debug', false) || $request->has(config('encbuddy.query_params.request', 'encreq'));
    }

    private function canEncrypt(Request $request)
    {
        return !config('app.debug', false) || $request->has(config('encbuddy.query_params.response', 'encres'));
    }

    private function shouldNotEncrypt(Request $request)
    {
        $except = config('encbuddy.except', []);
        return Str::is($except, $request->path());
    }
}
