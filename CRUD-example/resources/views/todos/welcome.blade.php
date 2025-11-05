<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>CRUD Example</title>
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
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                <h2 class="text-4xl font-bold text-white flex items-center justify-between">
                    Zadania
                    <div class="flex space-x-4">
                        
                        <a href="{{ route('todo.trash') }}" class="bg-yellow-400 text-black px-5 py-2 rounded-lg font-large hover:bg-yellow-300 transition">
                            Kosz ({{ $trashCount }})
                        </a>

                        <a href="{{ route('todo.create') }}" class="bg-white text-indigo-600 px-5 py-2 rounded-lg font-large hover:bg-indigo-50 transition">
                            Dodaj zadanie
                        </a>
                    </div>
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider"></th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Nazwa zadania</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Akcje</th>
                        </tr>
                    </thead>
                    
                    <tbody class="bg-white divide-y divide-gray-200">
                        
                        @forelse ($tasks as $task)
                            <tr class="hover:bg-gray-50 transition {{ $task->completed_at ? 'bg-gray-100 text-gray-500 line-through' : '' }}">
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('todo.toggle', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input 
                                            type="checkbox" 
                                            class="rounded border-gray-300"
                                            {{ $task->completed_at ? 'checked' : '' }}
                                            onchange="this.form.submit()"
                                        >
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $task->completed_at ? 'text-gray-500' : 'text-gray-900' }}">
                                    {{ $task->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm {{ $task->completed_at ? 'text-gray-500' : 'text-gray-700' }}">
                                    {{ $task->nazwa_zadania }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $task->deadline }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                    
                                    @if (!$task->completed_at)
                                        <a href="{{ route('todo.show', $task->id) }}" class="inline-block px-3 py-1 rounded-md text-xs font-medium transition bg-blue-500 text-white hover:bg-blue-600">
                                            View
                                        </a>
                                    
                                        <form action="{{ route('todo.softDelete', $task->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 rounded-md text-xs font-medium transition bg-orange-500 text-white hover:bg-orange-600">
                                                Soft Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-green-500 font-medium">Ukończone</span>
                                    @endif
                                    <form action="{{ route('todo.destroy', $task->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Czy na pewno chcesz usunąć to zadanie NA STAŁE?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 rounded-md text-xs font-medium transition bg-red-600 text-white hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="hover:bg-gray-50 transition">
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Brak zadań</p>
                                        <p class="text-sm text-gray-400">Kliknij „+ Dodaj zadanie”, by zacząć!</p>
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
                        zadań
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