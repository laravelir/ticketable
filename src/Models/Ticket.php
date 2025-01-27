<?php

namespace Laravelir\Ticketable\Models;

use App\Enums\TicketStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Miladimos\Toolkit\Traits\HasUUID;
use Miladimos\Toolkit\Traits\RouteKeyNameUUID;

class Ticket extends Model
{
    use HasUUID,
        RouteKeyNameUUID,
        SoftDeletes;

    protected $table = 'tickets';

    // protected $fillable = ['title', 'body', 'done', 'done_at', 'uuid', 'code'];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $with = ['admin', 'subject', 'children'];

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

    public function ticketable()
    {
        return $this->morphTo();
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function subject()
    {
        return $this->belongsTo(TicketSubject::class, 'subject_id');
    }

    public function status()
    {
        return $this->status;
    }

    public function priority()
    {
        return $this->priority;
    }

    public function parent()
    {
        return $this->belongsTo(Ticket::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Ticket::class, 'parent_id', 'id');
    }

    public function reply($data)
    {
        $user = Auth::user();

        $this->update([
            'status' => TicketStatusEnum::IN_PROGRESS,
        ]);

        $replayTicket = Ticket::create([
            'body' => $data['body'],
            'parent_id' => $this->id,
            'admin_id' => $user->id,
            'ticketable_id' => $this->ticketable_id,
            'ticketable_type' => $this->ticketable_type,
            'status' => TicketStatusEnum::IN_PROGRESS,
            // 'is_reply'        => true
        ]);

        // if ($request->hasFile('file')) {
        //     $uploadedFilePath = $this->uploadOneFile($request->file('file'), 'tickets\attachment');
        //     $replayTicket->update([
        //         'attachment' => $uploadedFilePath
        //     ]);
        // }

        // $details = [
        //     'user' => $this->ticketable,
        //     'title' => $this->title,
        //     'type'  => 'reply'
        // ];

        // try {
        //     event(new SendNewTicketEvent($details));
        // } catch (Exception $e) {
        // }

        return true;
    }

    public function done()
    {
        $this->update([
            'status' => TicketStatusEnum::DONE,
            'done' => true,
            'done_at' => now(),
        ]);
    }

    public function open()
    {
        $this->update([
            'status' => TicketStatusEnum::DONE,
            'done' => false,
            'done_at' => null,
        ]);
    }
}
