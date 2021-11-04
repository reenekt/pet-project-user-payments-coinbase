<?php

namespace App\Http\Middleware;

use App\Exceptions\CoinbaseException;
use Closure;
use Illuminate\Http\Request;

class CoinbaseWebhookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->checkUserAgent($request) || !$this->checkWebhookSignature($request)) {
            throw CoinbaseException::webhookException();
        }

        return $next($request);
    }

    /**
     * Check User-Agent header
     *
     * @param Request $request
     * @return bool
     */
    protected function checkUserAgent(Request $request): bool
    {
        return $request->userAgent() !== null && $request->userAgent() === 'weipay-webhooks';
    }

    /**
     * Check webhook signature
     *
     * @param Request $request
     * @return bool
     */
    protected function checkWebhookSignature(Request $request): bool
    {
        $secret = env('COINBASE_COMMERCE_WEBHOOKS_SECRET');
        $payload = $request->getContent();
        $signatureHeader = $request->header('X-CC-Webhook-Signature');

        if (!$secret || !$payload || !$signatureHeader) {
            logger()->error('Invalid secret of payload', compact(
                'secret',
                'payload',
                'signatureHeader',
                'request'
            ));
            return false;
        }

        if (!function_exists('hash_equals')) {
            logger()->error('hash_equals function does not exist', compact(
                'secret',
                'payload',
                'signatureHeader',
                'request'
            ));
            return false;
        }

        $computedSignature = \hash_hmac('sha256', $payload, $secret);

        return \hash_equals($signatureHeader, $computedSignature);
    }
}
