<?php

namespace Laravelir\Ticketable\Enums;

enum TicketPriorityEnum: string
{
    case EMERGENCY = 'a';
    case HIGHT = 'b';
    case AVERAGE = 'c';
    case LOW = 'd';
}
