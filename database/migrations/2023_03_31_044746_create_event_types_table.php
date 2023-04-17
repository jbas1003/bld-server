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
        Schema::create('tblevent_types', function (Blueprint $table) {
            $table->id('event_type_id');
            $table->string('event_type_name');
            $table->integer('event_type_category')->nullable();
            $table->integer('created_by');
            $table->string('created_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblevent_types');
    }
};
