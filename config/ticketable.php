<?php

// config file for laravelir/ticketable

return [
    'tickets' => [
        'model' => Laravelir\Ticketable\Models\Ticket::class,
    ],

    'subjects' => [
        'model' => Laravelir\Ticketable\Models\TicketSubject::class,
    ],

    'admin' => App\Models\User::class,
];
