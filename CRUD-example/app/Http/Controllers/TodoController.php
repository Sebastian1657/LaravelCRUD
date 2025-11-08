<?php

namespace App\Http\Controllers;

use App\Models\Todos;
use App\Models\Kategoria;
use App\Models\Users;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TodoController extends Controller
{
    public function index()
    {
        // Pobiera wszystkie zadania z bazy, ale podzielone na strony (po 10 na stronę)
        $tasks = Todos::paginate(10);
        
        // Pobiera liczbę zadań w koszu
        $trashCount = Todos::onlyTrashed()->count();
        
        // Zwraca widok 'welcome' i przekazuje mu zadania oraz licznik
        return view('todos.welcome', [
            'tasks' => $tasks,
            'trashCount' => $trashCount
        ]);
    }

    public function create()
    {
        $categories = Kategoria::all();
        $users = Users::all();

        // Przekaż je do widoku
        return view('todos.create', [
            'categories' => $categories,
            'users'=> $users
        ]);
    }

    public function store(Request $request)
    {
        // Walidacja danych (sprawdza, czy pole nie jest puste)
        $validated = $request->validate([
            'nazwa_zadania' => 'required|string|max:255',
            'categories_id' => 'required|exists:categories,id',
            'tresc_zadania' => 'nullable|string',
            'deadline' => 'nullable|date',
            'users'=> 'nullable|array',
            'users.*'=> 'exists:users,id'
        ]);

        
        $user_ids = [];
        if (array_key_exists('users', $validated)) {
            $user_ids = $validated['users'];
            // Usuń 'users' z $validated, bo nie ma tej kolumny w tabeli 'todos'
            unset($validated['users']);
        }

        // Stworzenie nowego rekordu w bazie
        $task = Todos::create($validated);

        if (!empty($user_ids)) {
            $task->users()->sync($user_ids);
        }

        // Przekierowanie z powrotem na główną listę
        return redirect('/')->with('message', 'Nowe zadanie zostało dodane!');
    }

    public function show(string $id)
    {
        // Znajdź zadanie o danym ID (lub zwróć błąd 404)
        $task = Todos::findOrFail($id);
        
        // Zwróć nowy widok 'show.blade.php' i przekaż mu zadanie
        return view('todos.show', ['task' => $task]);
    }

    public function edit(string $id)
    {
        // Znajdź zadanie, które chcemy edytować
        $task = Todos::findOrFail($id);
        // przypisz do zmiennej wszystkie kategorie z tabeli categories
        $categories = Kategoria::all();
        // przypisz do zmiennej wszystkich użytkowników z tabeli users
        $all_users = Users::all();
        // przypisz do zmiennej wszystkich przypisanych do zadania użytkowników
        $assigned_users = $task->users->pluck('id')->toArray();

        // Zwróć nowy widok z zadaniem
        return view('todos.edit', [
            'task' => $task,
            'categories' => $categories,
            'all_users'=> $all_users,
            'assigned_users'=> $assigned_users,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $task = Todos::findOrFail($id);

        $validated = $request->validate([
            'nazwa_zadania' => 'required|string|max:255',
            'tresc_zadania' => 'nullable|string',
            'deadline' => 'nullable|date',
            'categories_id'=> 'required|exists:categories,id',
            // walidujemy dane o użytkownikach
            'users'=> 'nullable|array',
            'users.*'=> 'exists:users,id'
        ]);

        // z racji, że w tabeli todos nie ma pola na użytkowników (jest ono w tabeli pośredniej relacji n:m),
        // musimy usunąć te pole, zanim przekażemy dane do polecenia update().
        $user_ids = [];
        if (array_key_exists('users', $validated)) {
            $user_ids = $validated['users'];
            unset($validated['users']);
        }

        $task->update($validated);
        // synchoronizujemy użytkowników z tabelami połączonymi relacją n:m
        $task->users()->sync($user_ids);

        return redirect('/')->with('message', 'Zadanie zostało zaktualizowane!');
    }

    public function destroy(string $id)
    {
        $task = Todos::withTrashed()->findOrFail($id);
        $task->forceDelete();
        
        return redirect('/')->with('message', 'Zadanie usunięte na stałe!');
    }
    public function softDelete(string $id)
    {
        $task = Todos::findOrFail($id);
        $task->delete();
        
        return redirect('/')->with('message', 'Zadanie przeniesione do kosza!');
    }

    public function trash()
    {
        // Pobiera TYLKO usunięte zadania
        $tasks = Todos::onlyTrashed()->paginate(10);
        
        // Zwraca nowy widok
        return view('todos.trash', ['tasks' => $tasks]);
    }

    public function restore(string $id)
    {
        $task = Todos::withTrashed()->findOrFail($id);

        // Metoda restore(), aby ustawia pole 'deleted_at' na NULL
        $task->restore();

        // Przekieruj z powrotem do kosza z komunikatem
        return redirect()->route('todo.trash')->with('message', 'Zadanie zostało przywrócone!');
    }

    public function toggleComplete(string $id)
    {
        $task = Todos::findOrFail($id);

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
