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
            $table->integer('emergencyContactInfo_id');
            $table->integer('member_id');
            $table->integer('created_by');
            $table->string('created_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('emergency_contacts');
    }
};
