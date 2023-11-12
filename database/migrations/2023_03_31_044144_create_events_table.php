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
        Schema::create('tblevents', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('event_name');
            $table->string('event_subtitle')->nullable();
            $table->longText('event_details')->nullable();
            $table->string('location')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('status');
            $table->integer('event_type_id');
            $table->integer('created_by');
            $table->string('created_on');
        });

        // Schema::table('tblevents', function (Blueprint $table) {
        //     $table->string('location')->nullable()->after('event_subtitle');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
