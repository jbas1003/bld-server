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
<<<<<<< Updated upstream:database/migrations/2023_04_01_072625_create_emergency_contacts_table.php
        Schema::create('tblemergency_contacts', function (Blueprint $table) {
            $table->id('emergencyContact_id');
<<<<<<< Updated upstream:database/migrations/2023_04_22_075442_create_emergency_contacts_table.php
            $table->integer('seId');
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
=======
            $table->integer('emergencyContactInfo_id');
            $table->integer('member_id');
=======
        Schema::create('tblinvites', function (Blueprint $table) {
            $table->id('invite_id');
            $table->integer('encounter_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->integer('inviter_id')->nullable();
            $table->string('relationship')->nullable();
>>>>>>> Stashed changes:database/migrations/2023_04_22_074606_create_invites_table.php
>>>>>>> Stashed changes:database/migrations/2023_04_01_072625_create_emergency_contacts_table.php
            $table->integer('created_by');
            $table->string('created_on');
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
