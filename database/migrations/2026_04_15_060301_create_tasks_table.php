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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->enum('status', ['new', 'in_progress', 'completed', 'cancelled'])->default('new');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('low');
            $table->date('due_date');
            $table->foreignId('author_id')->unsigned()->constrained();//->on('users');
            $table->foreignId('assignee_id')->unsigned()->constrained('users');//->on('users');
            $table->foreignId('project_id')->unsigned()->constrained();//->on('projects');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
