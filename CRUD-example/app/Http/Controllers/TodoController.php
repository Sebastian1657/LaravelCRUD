<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Kategoria;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TodoController extends Controller
{
    public function index()
    {
        // Pobiera wszystkie zadania z bazy, ale podzielone na strony (po 10 na stronę)
        $tasks = Todo::paginate(10);
        
        // Pobiera liczbę zadań w koszu
        $trashCount = Todo::onlyTrashed()->count();
        
        // Zwraca widok 'welcome' i przekazuje mu zadania oraz licznik
        return view('todos.welcome', [
            'tasks' => $tasks,
            'trashCount' => $trashCount
        ]);
    }

    public function create()
    {

    $categories = Kategoria::all();

    // Przekaż je do widoku
    return view('todos.create', ['categories' => $categories]);
        
    }

    public function store(Request $request)
    {
        // Walidacja danych (sprawdza, czy pole nie jest puste)
        $validated = $request->validate([
            'nazwa_zadania' => 'required|string|max:255',
            'tresc_zadania' => 'nullable|string',
            'deadline' => 'nullable|date',
            'category_id' => 'exists:categories,id'
        ]);

        // Stworzenie nowego rekordu w bazie
        Todo::create($validated);

        // Przekierowanie z powrotem na główną listę
        return redirect('/')->with('message', 'Nowe zadanie zostało dodane!');
    }

    public function show(string $id)
    {
        // Znajdź zadanie o danym ID (lub zwróć błąd 404)
        $task = Todo::findOrFail($id);
        
        // Zwróć nowy widok 'show.blade.php' i przekaż mu zadanie
        return view('todos.show', ['task' => $task]);
    }

    public function edit(string $id)
    {
        // Znajdź zadanie, które chcemy edytować
        $task = Todo::findOrFail($id);
        $categories = Kategoria::all(); 
        
        // Zwróć nowy widok z zadaniem
        return view('todos.edit', [
        'task' => $task,
        'categories' => $categories // <-- Przekaż kategorie
    ]);
    }

    public function update(Request $request, string $id)
    {
        $task = Todo::findOrFail($id);

        $validated = $request->validate([
            'nazwa_zadania' => 'required|string|max:255',
            'tresc_zadania' => 'nullable|string',
            'deadline' => 'nullable|date',
            'category_id'=> 'exists:categories,id'
        ]);

        $task->update($validated);

        return redirect('/')->with('message', 'Zadanie zostało zaktualizowane!');
    }

    public function destroy(string $id)
    {
        $task = Todo::withTrashed()->findOrFail($id);
        $task->forceDelete();
        
        return redirect('/')->with('message', 'Zadanie usunięte na stałe!');
    }
    public function softDelete(string $id)
    {
        $task = Todo::findOrFail($id);
        $task->delete();
        
        return redirect('/')->with('message', 'Zadanie przeniesione do kosza!');
    }

    public function trash()
    {
        // Pobiera TYLKO usunięte zadania
        $tasks = Todo::onlyTrashed()->paginate(10);
        
        // Zwraca nowy widok
        return view('todos.trash', ['tasks' => $tasks]);
    }

    public function restore(string $id)
    {
        $task = Todo::withTrashed()->findOrFail($id);

        // Metoda restore(), aby ustawia pole 'deleted_at' na NULL
        $task->restore();

        // Przekieruj z powrotem do kosza z komunikatem
        return redirect()->route('todo.trash')->with('message', 'Zadanie zostało przywrócone!');
    }

    public function toggleComplete(string $id)
    {
        $task = Todo::findOrFail($id);

        if ($task->completed_at) {
            // Jeśli tak, oznaczamy jako nieukończone (ustawiamy NULL)
            $task->completed_at = null;
            $message = 'Zadanie oznaczone jako nieukończone.';
        } else {
            // Jeśli nie, oznaczamy jako ukończone (wstawiamy aktualny czas)
            $task->completed_at = Carbon::now();
            $message = 'Zadanie ukończone!';
        }

        $task->save();
        return redirect('/')->with('message', $message);
    }
}
