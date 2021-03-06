<?php

namespace Nuwave\Lighthouse\Subscriptions\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Nuwave\Lighthouse\Subscriptions\Contracts\BroadcastsSubscriptions;

class BroadcastSubscriptionListener implements ShouldQueue
{
    /**
     * @var \Nuwave\Lighthouse\Subscriptions\Contracts\BroadcastsSubscriptions
     */
    protected $broadcaster;

    public function __construct(BroadcastsSubscriptions $broadcaster)
    {
        $this->broadcaster = $broadcaster;
    }

    /**
     * Handle the event.
     *
     * @param  \Nuwave\Lighthouse\Subscriptions\Events\BroadcastSubscriptionEvent  $event
     */
    public function handle(BroadcastSubscriptionEvent $event): void
    {
        $this->broadcaster->broadcast(
            $event->subscription,
            $event->fieldName,
            $event->root
        );
    }
}
