<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserAuthorized;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TelegramVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class TelegramVerificationController extends Controller
{
    /**
     * Show the email verification prompt page.
     */
    public function show(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedTelegram()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : Inertia::render('auth/VerifyTelegram', ['status' => $request->session()->get('status')]);
    }

    /**
     * Send a new verification code.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedTelegram()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        try {
            $request->user()->sendTelegramVerificationNotification();

            return back()->with('status', 'verification-code-sent');
        } catch (RuntimeException $e) {
            return back()->withErrors(['telegram' => $e->getMessage()]);
        }
    }

    /**
     * Verify the Telegram code.
     */
    public function update(TelegramVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedTelegram()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->verify()) {
            $user = $request->user();
            event(new UserAuthorized($user->name));

            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        return back()->withErrors(['code' => 'Invalid or expired verification code']);
    }
}
