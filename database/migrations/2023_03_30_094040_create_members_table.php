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
            $table->string('nickname')->nullable();
            $table->string('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->integer('spouse_member_id')->nullable();
            $table->string('religion')->nullable();
            $table->string('baptism')->nullable();
            $table->string('confirmation')->nullable();
            $table->string('member_status_id');
            $table->string('created_by');
            $table->string('created_on');
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
