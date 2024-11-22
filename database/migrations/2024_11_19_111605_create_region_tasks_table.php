<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('region_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();          
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();  
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();  
            $table->date('deadline');
            $table->integer('status')->default(1);        
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('region_tasks');
    }
};
