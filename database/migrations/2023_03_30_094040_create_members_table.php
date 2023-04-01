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
        Schema::create('tblmembers', function (Blueprint $table) {
            $table->id('member_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('nickname');
            $table->string('birthday');
            $table->string('gender');
            $table->string('religion');
            $table->string('baptism');
            $table->string('confirmation');
            $table->string('occupation');
            $table->string('specialty');
            $table->string('company');
            $table->string('company_address');
            $table->string('member_status');
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
        Schema::dropIfExists('members');
    }
};
