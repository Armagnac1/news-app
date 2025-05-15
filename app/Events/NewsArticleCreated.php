<?php

namespace App\Events;

use App\Models\NewsArticle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsArticleCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public NewsArticle $article) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('public'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'news.created';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->article->id,
            'title' => $this->article->title,
        ];
    }
}
