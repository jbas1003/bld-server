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
            $table->integer('yeId')->nullable();
            $table->integer('seId')->nullable();
            $table->integer('meId')->nullable();
            $table->integer('speId')->nullable();
            $table->integer('feId')->nullable();
            $table->integer('ylssId')->nullable();
            $table->integer('lssId')->nullable();
            $table->string('name')->nullable();
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
