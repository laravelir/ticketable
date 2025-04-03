<?php

namespace Laravelir\Ticketable\Enums;

enum TicketStatusEnum: string
{
    case NEW = 'a';
    case WAIT_FOR_ANSWER = 'b';
    case DONE = 'c';
}
