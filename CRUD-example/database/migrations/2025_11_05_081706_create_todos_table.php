<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa_zadania');
            $table->text('tresc_zadania')->nullable();
            $table->date('deadline')->nullable();
            $table->timestamp('completed_at')->nullable(); // Tworzy completed_at
            $table->timestamps(); // Tworzy created_at i updated_at
            $table->softDeletes(); // KLUCZOWE DLA "SOFT DELETE"
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};