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
        Schema::create('tblsingles_encounter', function (Blueprint $table) {
            $table->id('seId');
            $table->integer('member_id')->nullable();
            $table->integer('emergencyContact_id')->nullable();
            $table->string('room')->nullable();
            $table->string('tribe')->nullable();
            $table->string('nation')->nullable();
            $table->integer('created_by');
            $table->string('created_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblsingles_encounter');
    }
};
