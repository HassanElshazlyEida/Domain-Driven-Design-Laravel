<?php

use Illuminate\Support\Facades\Schema;
use Domain\Automation\Models\Automation;
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
        Schema::create('automation_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Automation::class)->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('name');
            $table->json('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('automation_steps');
    }
};
