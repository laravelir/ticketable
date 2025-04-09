<?php

namespace Laravelir\Ticketable\Traits;

trait Ticketable
{
    public function tickets()
    {
        return $this->morphMany(config('ticketable.tickets.model'), 'ticketable');
    }
}
