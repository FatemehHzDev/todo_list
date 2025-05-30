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
        Schema::create('task_dos', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('user_id');
            $table->smallInteger('task_id')->unique();
            $table->string('date_do');
            $table->string('year');
            $table->string('month');
            $table->string('day');
            $table->string('status')->default('false');
            $table->string('approved')->default('false');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_dos');
    }
};
