<?php

namespace Laravelir\Ticketable\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class TicketSubject extends Model
{
    protected $table = 'ticketable_subjects';

    protected $guarded = [];

    public static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string)Uuid::generate(4);
        });
    }

    public function tickets()
    {
        return $this->hasMany(config('ticketable.tickets.model'));
    }
}
