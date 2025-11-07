<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Kosz - Lista ToDo</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans min-h-screen">
    <header class="bg-blue-600 text-white p-8 text-center shadow-lg">
        <h1 class="text-4xl font-bold">Lista ToDo</h1>
        <p class="mt-2 text-blue-100">Zadania do wykonania – Laravel + blade + Tailwind</p>
    </header>

    <main class="max-w-4/5 max- mx-auto my-12 px-4">

        @if (session('message'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="bg-linear-to-r from-indigo-500 to-purple-600 p-6">
                <h2 class="text-4xl font-bold text-white flex items-center justify-between">
                    Kosz
                    <a href="/" class="bg-white text-indigo-600 px-5 py-2 rounded-lg font-large hover:bg-indigo-50 transition">
                        &larr; Wróć do listy zadań
                    </a>
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Nazwa zadania</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Kategoria</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Akcje</th>
                        </tr>
                    </thead>
                    
                    <tbody class="bg-white divide-y divide-gray-200">
                        
                        @forelse ($tasks as $task)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $task->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $task->nazwa_zadania }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $task->kategoria }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $task->deleted_at->format('d.m.Y H:i') }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                    
                                    <form action="{{ route('todo.restore', $task->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1 rounded-md text-xs font-medium transition bg-green-500 text-white hover:bg-green-600">
                                            Przywróć
                                        </button>
                                    </form>

                                    <form action="{{ route('todo.destroy', $task->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Czy na pewno chcesz usunąć to zadanie NA STAŁE? Tej akcji nie można cofnąć.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 rounded-md text-xs font-medium transition bg-red-600 text-white hover:bg-red-700">
                                            Usuń trwale
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="hover:bg-gray-50 transition">
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        <p class="text-lg font-medium">Kosz jest pusty</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse 
                        
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <span>
                        Pokazuje 
                        <strong>{{ $tasks->firstItem() ?? 0 }}</strong> 
                        do 
                        <strong>{{ $tasks->lastItem() ?? 0 }}</strong> 
                        z 
                        <strong>{{ $tasks->total() }}</strong> 
                        usuniętych zadań
                    </span>
                    <div>
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>