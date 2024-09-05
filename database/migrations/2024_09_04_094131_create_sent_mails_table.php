<?php

use Domain\Shared\Models\User;
use Illuminate\Support\Facades\Schema;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_mails', function (Blueprint $table) {
            $table->id();
            $table->integer('sendable_id');
            $table->string('sendable_type');
            $table->foreignIdFor(Subscriber::class)->nullable(true)->constrained()->nullOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->dateTime('sent_at')->useCurrent();
            $table->dateTime('opened_at')->nullable();
            $table->dateTime('clicked_at')->nullable();

            $table->index('sent_at');
            $table->index('opened_at');
            $table->index('clicked_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sent_mails');
    }
};
