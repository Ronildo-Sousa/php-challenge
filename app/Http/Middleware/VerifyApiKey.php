<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->validate(['api_key' => ['required', 'alpha_dash']])['api_key'];

        $isValidApiKey = User::query()->where('api_key', $apiKey)->first(['id']);

        abort_if(!$isValidApiKey, Response::HTTP_UNAUTHORIZED, 'Invalid API Key');

        return $next($request);
    }
}
