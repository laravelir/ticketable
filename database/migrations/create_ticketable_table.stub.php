<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laravelir\Ticketable\Enums\TicketStatusEnum;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticketable_subjects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('ticketable_tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('code')->unique();
            $table->foreignId('admin_id')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('subject_id')->nullable();
            $table->string('title')->nullable();
            $table->text('body');
            $table->morphs('ticketable'); // user
            $table->boolean('done')->default(false);
            $table->timestamp('done_at')->nullable();
            $table->char('status', 1)->default(TicketStatusEnum::NEW->value);
            $table->boolean('is_reply')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticketable_subjects');
        Schema::dropIfExists('ticketable_tickets');
    }
};
