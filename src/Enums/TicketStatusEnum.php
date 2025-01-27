<?php

namespace Laravelir\Ticketable\Enums;

final class TicketStatusEnum
{
    const NEW = 'a';

    const WAIT_FOR_ANSWER = 'b'; // direct buy course

    const IN_PROGRESS = 'c'; // buy from wallet amount

    const DONE = 'c'; // buy from wallet amount
}
// enum ModelTypeEnum: string
// {
//     case PRODUCT = 'a';
//     case BOOK = 'b';
//     case PODCAST = 'c';
//     case POST = 'd';
//     case COURSE = 'e';
//     case EPISODE = 'f';
// }
