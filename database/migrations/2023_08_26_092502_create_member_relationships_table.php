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
        Schema::create('tblmember_relationships', function (Blueprint $table) {
            $table->id('member_relationship_id');
            $table->integer('member_id');
            $table->integer('relative_id');
            $table->integer('relationship_id');
            $table->integer('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblmember_relationships');
    }
};
