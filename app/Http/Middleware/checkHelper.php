<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class checkHelper
{
 
    public function handle($request, Closure $next)
    {
        $path = 'mtg.json';

        if (!Storage::disk('local')->exists($path)) {
            abort(403, __('الترخيص غير موجود برجاء الاتصال بالقسم المختص.'));
        }

        try {
            $license = json_decode(decrypt(Storage::disk('local')->get($path)), true);
        } catch (\Exception $e) {
            abort(403, 'License corrupted.');
        }

        if (
            !$license ||
            empty($license['is_active']) ||
            now()->greaterThan($license['expires_at'])
        ) {
            abort(403, __('License expired. Please renew.'));
        }

        return $next($request);
    }
}
