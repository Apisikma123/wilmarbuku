<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $identifier;
    public $cartCount;
    public $isAuthenticated;

    /**
     * Create a new event instance.
     */
    public function __construct($identifier, $cartCount, $isAuthenticated = true)
    {
        $this->identifier = $identifier;
        $this->cartCount = $cartCount;
        $this->isAuthenticated = $isAuthenticated;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        if ($this->isAuthenticated) {
            return [
                new PrivateChannel('user.' . $this->identifier),
            ];
        } else {
            return [
                new Channel('cart.guest.' . $this->identifier),
            ];
        }
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'cart.updated';
    }
}
