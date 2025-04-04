<?php

namespace Laravelir\Ticketable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelir\Ticketable\Enums\TicketStatusEnum;
use Webpatser\Uuid\Uuid;

class Ticket extends Model
{
    use SoftDeletes;

    protected $table = 'ticketable_tickets';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $with = ['admin', 'subject', 'replies'];

    public static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string)Uuid::generate(4);
            $model->code = $this->generateTicketCode();
        });
    }

    public function ticketable()
    {
        return $this->morphTo();
    }

    public function admin()
    {
        return $this->belongsTo(config('ticketable.admin'), 'admin_id');
    }

    public function subject()
    {
        return $this->belongsTo(config('ticketable.subjects.model'), 'subject_id');
    }

    public function parent()
    {
        return $this->belongsTo(config('ticketable.tickets.model'), 'id', 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(config('ticketable.tickets.model'), 'parent_id', 'id');
    }

    public function done()
    {
        $this->update([
            'status' => TicketStatusEnum::DONE->value,
            'done' => true,
            'done_at' => now(),
        ]);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public static function generateTicketCode()
    {
        do {
            $digits = array_merge(range(0, 9), range(0, 9), range(0, 9));
            $sChars = range('a', 'z');
            $cChars = range('A', 'Z');
            $chars = array_merge($digits, $sChars, $cChars);
            $arrToStr = implode('', $chars);
            $shuf = str_shuffle($arrToStr);
            $code = substr($shuf, 0, 8);
            $exist = true;

            if (! static::where('code', $code)->exists()) {
                $exist = false;

                return $code;
            }
        } while ($exist);
    }
}
