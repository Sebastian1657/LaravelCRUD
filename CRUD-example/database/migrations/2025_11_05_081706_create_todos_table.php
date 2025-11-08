<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('categories', function (Blueprint $table){
            $table->id();
            $table->string('kategoria');
        });
        DB::table('categories')->insert([
            ['kategoria' => 'Praca'],
            ['kategoria' => 'Zakupy'],
            ['kategoria' => 'Obowiązki'],
            ['kategoria' => 'Praca domowa']
        ]);
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa_zadania');
            $table->text('tresc_zadania')->nullable();
            $table->foreignId('categories_id') // Klucz obcy
              ->constrained('categories'); // Mówi, że łączy się z tabelą 'categories'
            $table->date('deadline')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps(); // Dla created_at i updated_at
            $table->softDeletes();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nick');
        });
        DB::table('users')->insert([
            ['nick' => 'Sebastian'],
            ['nick' => 'Jan'],
            ['nick' => 'Marcin'],
            ['nick' => 'Kamil']
        ]);
        Schema::create('todos_users', function (Blueprint $table){
            $table->id();
            $table ->foreignId('todos_id')
                ->constrained('todos');
            $table->foreignId('users_id')
                ->constrained('users');
            $table->timestamps();
        });
    }
    // php artisan migrate
    // php artisan migrate:fresh 

    public function down(): void
    {
        Schema::dropIfExists('todos_users');
        Schema::dropIfExists('users');
        Schema::dropIfExists('todos');
        Schema::dropIfExists('categories');
    }
};