<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daily_planner_templates', function (Blueprint $table) {
            $table->id();
            $table->enum('plan', ['starter', 'starter_plus']);
            $table->string('task');
            $table->string('time')->default('07:00');
            $table->integer('calories')->default(0);
            $table->boolean('is_default')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_planner_templates');
    }
};
