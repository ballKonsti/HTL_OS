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
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
            $table->string('pic_url');
            $table->foreignId('forward_id')->nullable()->constrained('nodes')->nullOnDelete();
            $table->foreignId('back_id')->nullable()->constrained('nodes')->nullOnDelete();
            $table->foreignId('right_id')->nullable()->constrained('nodes')->nullOnDelete();
            $table->foreignId('left_id')->nullable()->constrained('nodes')->nullOnDelete();
            $table->string('node_type')->default('hallway');
            $table->string('department')->nullable();
            $table->string('room_name')->nullable();
            $table->string('teacher_name')->nullable();
            $table->string('teacher_image')->nullable();
            $table->text('dialogue_text')->nullable();
            $table->json('project_images')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nodes');
    }
};
