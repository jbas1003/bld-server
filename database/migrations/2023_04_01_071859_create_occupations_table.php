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
        Schema::create('occupations', function (Blueprint $table) {
            $table->id('occupation_id');
            $table->string('occupation_name');
            $table->string('specialty');
            $table->string('company');
            $table->string('address_id');
            $table->string('created_by');
            $table->string('created_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupations');
    }
};
