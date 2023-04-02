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
        Schema::create('tblemercency_contactinfos', function (Blueprint $table) {
            $table->id('emergencyContactInfo_id');
            $table->string('member_id');
            $table->string('contactNumber_id');
            $table->string('created_by');
            $table->string('created_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emercency_contactinfos');
    }
};