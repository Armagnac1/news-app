<?php

namespace App\Models\Traits;

use App\Models\VerificationCode;
use App\Notifications\VerifyTelegram;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use RuntimeException;

trait MustVerifyTelegram
{
    public function hasVerifiedTelegram()
    {
        return ! is_null($this->telegram_verified_at);
    }

    public function markTelegramAsVerified()
    {
        return $this->forceFill([
            'telegram_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendTelegramVerificationNotification()
    {
        if (empty(config('services.telegram-bot-api.token'))) {
            throw new RuntimeException('Telegram bot token is not configured. Please set TELEGRAM_BOT_TOKEN in your .env file.');
        }

        if (empty(config('services.telegram-bot-api.channel'))) {
            throw new RuntimeException('Telegram channel is not configured. Please set TELEGRAM_CHANNEL in your .env file.');
        }

        // Create a new verification code
        $code = Str::random(6);
        $verificationCode = VerificationCode::create([
            'user_id' => $this->id,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(30),
        ]);

        $this->notify(new VerifyTelegram($code, $this->name));

        return $verificationCode;
    }

    /**
     * Verify the user's Telegram account using the provided code.
     */
    public function verify(string $code): bool
    {
        $verificationCode = $this->getLatestVerificationCode();

        if (! $verificationCode || $verificationCode->code !== $code) {
            return false;
        }

        $verificationCode->update([
            'is_used' => true,
            'used_at' => now(),
        ]);

        return $this->markTelegramAsVerified();
    }

    /**
     * Route notifications for the Telegram channel.
     *
     * @return string
     */
    public function routeNotificationForTelegram()
    {
        return '@'.config('services.telegram.channel');
    }

    /**
     * Get the latest valid verification code for this user.
     */
    public function getLatestVerificationCode(): ?VerificationCode
    {
        return $this->verificationCodes()
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();
    }

    /**
     * Get all verification codes for this user.
     */
    public function verificationCodes()
    {
        return $this->hasMany(VerificationCode::class);
    }
}
