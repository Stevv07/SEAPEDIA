<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestBroadcastEvent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public string $message;

    public function __construct()
    {
        $this->message = 'Halo, ini test broadcast!';
    }

    public function broadcastOn(): Channel
    {
        return new Channel('public-test');
    }

    public function broadcastAs(): string
    {
        return 'test-event';
    }
}