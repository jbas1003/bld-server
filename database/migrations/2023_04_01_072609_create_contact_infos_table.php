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
        Schema::create('tblcontact_infos', function (Blueprint $table) {
            $table->id('contactInfo_id');
            $table->integer('member_id');
            $table->integer('address_id');
            $table->integer('contactNumber_id');
            $table->integer('email_id');
            $table->integer('occupation_id');
            $table->integer('created_by');
            $table->string('created_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('contact_infos');
    }
};
