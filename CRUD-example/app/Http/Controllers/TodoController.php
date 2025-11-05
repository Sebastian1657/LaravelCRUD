<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pobiera wszystkie zadania z bazy, ale podzielone na strony (po 10 na stronę)
        $tasks = Todo::paginate(10);
        
        // DODAJEMY TĘ LINIJKĘ: Pobiera liczbę zadań w koszu
        $trashCount = Todo::onlyTrashed()->count();
        
        // Zwraca widok 'welcome' i przekazuje mu zadania ORAZ licznik
        return view('todos.welcome', [
            'tasks' => $tasks,
            'trashCount' => $trashCount // <-- Przekazujemy licznik
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Walidacja danych (sprawdza, czy pole nie jest puste)
        $validated = $request->validate([
            'nazwa_zadania' => 'required|string|max:255',
            'tresc_zadania' => 'nullable|string',
            'deadline' => 'nullable|date', // 'nullable' oznacza, że nie jest wymagane
        ]);

        // 2. Stworzenie nowego rekordu w bazie
        Todo::create($validated);

        // 3. Przekierowanie z powrotem na główną listę z komunikatem
        return redirect('/')->with('message', 'Nowe zadanie zostało dodane!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. Znajdź zadanie o danym ID (lub zwróć błąd 404)
        $task = Todo::findOrFail($id);
        
        // 2. Zwróć nowy widok 'show.blade.php' i przekaż mu zadanie
        return view('todos.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 1. Znajdź zadanie, które chcemy edytować
        $task = Todo::findOrFail($id);
        
        // 2. Zwróć nowy widok 'edit.blade.php' i przekaż mu to zadanie
        return view('todos.edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Znajdź zadanie
        $task = Todo::findOrFail($id);

        // 2. Walidacja danych (tak jak w 'store')
        $validated = $request->validate([
            'nazwa_zadania' => 'required|string|max:255',
            'tresc_zadania' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        // 3. Zaktualizuj zadanie w bazie
        $task->update($validated);

        // 4. Przekieruj na listę z komunikatem
        return redirect('/')->with('message', 'Zadanie zostało zaktualizowane!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Todo::withTrashed()->findOrFail($id); // Znajdź zadanie (nawet to po soft delete)
        $task->forceDelete(); // Usuń na twardo
        
        return redirect('/')->with('message', 'Zadanie usunięte na stałe!');
    }
    /**
     * Przenosi zadania do kosza (soft-delete).
     */
    public function softDelete(string $id)
    {
        $task = Todo::findOrFail($id);
        $task->delete(); // To uruchomi Soft Delete dzięki Trait w Modelu
        
        return redirect('/')->with('message', 'Zadanie przeniesione do kosza!');
    }

    /**
     * Wyświetla listę zadań w koszu (soft-deleted).
     */
    public function trash()
    {
        // Pobiera TYLKO usunięte zadania, również z paginacją
        $tasks = Todo::onlyTrashed()->paginate(10);
        
        // Zwraca nowy widok 'trash.blade.php', który zaraz stworzymy
        return view('todos.trash', ['tasks' => $tasks]);
    }

    /**
     * Przywraca zadanie z kosza.
     */
    public function restore(string $id)
    {
        // 1. Znajdź zadanie (szukamy wśród WSZYSTKICH, także usuniętych)
        $task = Todo::withTrashed()->findOrFail($id);

        // 2. Użyj metody restore(), aby ustawić 'deleted_at' na NULL
        $task->restore();

        // 3. Przekieruj z powrotem do kosza z komunikatem
        return redirect()->route('todo.trash')->with('message', 'Zadanie zostało przywrócone!');
    }
    /**
 * Oznacza zadanie jako ukończone lub nieukończone.
 */
public function toggleComplete(string $id)
{
    $task = Todo::findOrFail($id);

    // Sprawdzamy, czy zadanie jest już ukończone
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

    // Wracamy na stronę główną z komunikatem
    return redirect('/')->with('message', $message);
}
}
