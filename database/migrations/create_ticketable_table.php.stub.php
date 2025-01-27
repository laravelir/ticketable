<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laravelir\Ticketable\Enums\TicketStatusEnum;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_subjects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->string('code')->unique();
            $table->foreignId('admin_id')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('subject_id')->nullable();
            $table->string('title')->nullable();
            $table->text('body');
            $table->morphs('ticketable');
            $table->boolean('done')->default(false);
            $table->timestamp('done_at')->nullable();
            $table->char('status', 1)->default(TicketStatusEnum::NEW);
            $table->boolean('is_reply')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admin_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('parent_id')
                ->on('tickets')
                ->references('id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('subject_id')
                ->references('id')->on('ticket_subjects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_subjects');

        Schema::dropIfExists('tickets');
    }
}
