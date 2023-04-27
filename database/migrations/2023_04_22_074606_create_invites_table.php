<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblinvites', function (Blueprint $table) {
            $table->id('invite_id');
            $table->integer('encounter_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->integer('inviter_id')->nullable();
            $table->string('relationship')->nullable();
            $table->integer('created_by');
            $table->string('created_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblinvites');
    }
};
