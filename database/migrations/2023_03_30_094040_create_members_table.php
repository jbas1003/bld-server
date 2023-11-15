<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblmembers', function (Blueprint $table) {
            $table->id('member_id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->integer('spouse')->nullable();
            $table->string('religion')->nullable();
            $table->string('baptism')->nullable();
            $table->string('confirmation')->nullable();
            $table->integer('member_status_id')->nullable();
            $table->integer('created_by');
            $table->string('created_on');
        });

        // Schema::table('tblmembers', function (Blueprint $table) {
        //     $table->renameColumn('spouse_member_id', 'spouse');
        // });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblmembers');
    }

};
