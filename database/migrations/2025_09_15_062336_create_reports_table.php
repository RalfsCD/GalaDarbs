<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('reports', function (Blueprint $table) {
    $table->id();
    $table->foreignId('post_id')->nullable()->constrained('posts')->nullOnDelete(); // key change
    $table->foreignId('reported_user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
    $table->string('reason');
    $table->text('details')->nullable();
    $table->boolean('resolved')->default(false);
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