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
        Schema::create('tblemergency_contacts', function (Blueprint $table) {
            $table->id('emergencyContact_id');
            $table->integer('seId')->nullable();
            $table->integer('yeId')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('relationship')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('created_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblemergency_contacts');
    }
};
