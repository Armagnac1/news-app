<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class VerifyTelegram extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $code;

    protected string $username;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $code, string $username)
    {
        $this->code = $code;
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the Telegram representation of the notification.
     */
    public function toTelegram(object $notifiable): TelegramMessage
    {
        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.channel'))
            ->content("🔐 Verification Code for {$this->username}\n\nCode: `{$this->code}`\n\nPlease use this code to verify your account.")
            ->parseMode('Markdown');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'telegram_verification',
            'user_id' => $notifiable->id,
            'code' => $this->code,
            'username' => $this->username,
        ];
    }
}
