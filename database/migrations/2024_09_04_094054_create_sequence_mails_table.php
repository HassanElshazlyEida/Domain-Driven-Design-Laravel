<?php

use Domain\Shared\Models\User;
use Illuminate\Support\Facades\Schema;
use Domain\Mail\Models\Sequence\Sequence;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequence_mails', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sequence::class)->constrained();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->text('content');
            $table->string('status')->default(SequenceMailStatus::Draft->value);
            $table->json('filters')->nullable(true);
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
        Schema::dropIfExists('sequence_mails');
    }
};
