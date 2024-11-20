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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('report_type_id')->constrained('report_types');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('church_id')->nullable()->constrained('churches');
            $table->foreignId('district_id')->nullable()->constrained('districts');
            $table->foreignId('state_id')->nullable()->constrained('states');
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};