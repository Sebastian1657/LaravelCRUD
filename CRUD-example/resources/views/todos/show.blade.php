<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Podgląd Zadania</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans min-h-screen">
    <header class="bg-blue-600 text-white p-8 text-center shadow-lg">
        <h1 class="text-4xl font-bold">Lista ToDo</h1>
    </header>

    <main class="max-w-2xl mx-auto my-12 px-4">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="bg-linear-to-r from-indigo-500 to-purple-600 p-6">
                <h2 class="text-4xl font-bold text-white">
                    {{ $task->nazwa_zadania }}
                </h2>
                <h2 class="text-4xl font-bold text-white">
                    {{ $task->kategoria }}
                </h2>
                @if ($task->deadline)
                    <p class="text-indigo-100 mt-2">Deadline: {{ $task->deadline }}</p>
                @endif
            </div>

            <div class="p-8 space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Treść zadania:</h3>
                    <div class="p-4 bg-gray-50 rounded-lg text-gray-700 whitespace-pre-wrap">
                        {{ $task->tresc_zadania ?? 'Brak opisu.' }}
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Przypisani użytkownicy:</h3>
                    <div class="flex flex-wrap gap-2">
                    @forelse ($task->users as $user)
                        <span class="rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-800">
                            {{ $user->nick }}
                        </span>
                    @empty
                        <p class="text-sm text-gray-500">Brak przypisanych użytkowników. Musisz poradzić sobie sam :)</p>
                    @endforelse
                </div>
                </div>

                <div class="text-sm text-gray-500 border-t border-gray-200 pt-4">
                    <p>Utworzono: {{ $task->created_at->format('d.m.Y H:i') }}</p>
                    <p>Ostatnia edycja: {{ $task->updated_at->format('d.m.Y H:i') }}</p>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="/" class="px-5 py-2 rounded-lg font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                        &larr; Wróć do listy
                    </a>
                    <a href="{{ route('todo.edit', $task->id) }}" class="px-5 py-2 rounded-lg font-medium text-white bg-yellow-500 hover:bg-yellow-600 transition">
                        Update
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>