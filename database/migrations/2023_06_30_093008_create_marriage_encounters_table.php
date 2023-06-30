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
        Schema::create('tblmarriage_encounter', function (Blueprint $table) {
            $table->id('meId');
            $table->integer('member_id')->nullable();
            $table->string('room')->nullable();
            $table->string('spouse')->nullable();
            $table->integer('event_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by');
            $table->string('created_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblmarriage_encounter');
    }
};
