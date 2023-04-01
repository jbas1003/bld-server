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
        Schema::create('tblevents', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('event_name');
            $table->string('event_type_id');
            $table->string('created_by');
            $table->string('created_on');
            $table->string('updated_by');
            $table->string('updated_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
