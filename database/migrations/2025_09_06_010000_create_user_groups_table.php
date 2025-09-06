<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Groups table
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot table: group members
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('user_groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['group_id', 'user_id']);
        });

        // Pivot table: group topics
        Schema::create('group_topic', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('user_groups')->onDelete('cascade');
            $table->foreignId('topic_id')->constrained('topics')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['group_id', 'topic_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('group_topic');
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('user_groups');
    }
};
