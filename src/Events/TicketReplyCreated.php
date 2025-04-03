<?php

namespace Laravelir\Ticketable\Events;

use Illuminate\Queue\SerializesModels;
use Laravelir\Ticketable\Models\Ticket;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

class TicketReplyCreated implements ShouldDispatchAfterCommit
{
    use SerializesModels, Dispatchable, InteractsWithSockets;

    public function __construct(public Ticket $comment) {}
}
