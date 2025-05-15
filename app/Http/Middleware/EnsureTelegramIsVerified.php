<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTelegramIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasVerifiedTelegram()) {
            return redirect()->route('telegram-verification.notice')->with('error', 'Please verify your Telegram account.');
        }

        return $next($request);
    }
}
