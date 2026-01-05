<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('path')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->date('visited_date');
            $table->timestamps();

            $table->index(['visited_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
