<?php

use Domain\Shared\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcasts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('subject')->nullable(false);
            $table->text('content')->nullable(false);
            $table->json('filters')->nullable(true);
            $table->string('status')->default(BroadcastStatus::Draft->value);
            $table->dateTime('sent_at')->nullable(true);
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('broadcasts');
    }
};
