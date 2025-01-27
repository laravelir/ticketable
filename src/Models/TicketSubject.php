<?php

namespace Laravelir\Ticketable\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Miladimos\Toolkit\Traits\HasUUID;

class TicketSubject extends Model
{
    use HasUUID,
        Sluggable,
        SoftDeletes;

    protected $table = 'ticket_subjects';

    protected $fillable = ['title', 'slug'];

    // protected $guarded = [''];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
