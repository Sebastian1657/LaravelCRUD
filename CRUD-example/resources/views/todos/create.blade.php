<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Dodaj Nowe Zadanie</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans min-h-screen">
    <header class="bg-blue-600 text-white p-8 text-center shadow-lg">
        <h1 class="text-4xl font-bold">Lista ToDo</h1>
    </header>

    <main class="max-w-2xl mx-auto my-12 px-4">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                <h2 class="text-4xl font-bold text-white">
                    Nowe zadanie
                </h2>
            </div>

            <form action="{{ route('todo.store') }}" method="POST" class="p-8 space-y-6">
                @csrf <div>
                    <label for="nazwa_zadania" class="block text-sm font-medium text-gray-700 mb-1">
                        Nazwa zadania
                    </label>
                    <input 
                        type="text" 
                        name="nazwa_zadania" 
                        id="nazwa_zadania" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                        required
                        autofocus
                    >
                    @error('nazwa_zadania')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tresc_zadania" class="block text-sm font-medium text-gray-700 mb-1">
                        Treść zadania (opcjonalnie)
                    </label>
                    <textarea 
                        name="tresc_zadania" 
                        id="tresc_zadania" 
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    ></textarea>
                    @error('tresc_zadania')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">
                        Deadline (opcjonalnie)
                    </label>
                    <input 
                        type="date" 
                        name="deadline" 
                        id="deadline"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    @error('deadline')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="/" class="px-5 py-2 rounded-lg font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                        Anuluj
                    </a>
                    <button type="submit" class="px-5 py-2 rounded-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        Zapisz zadanie
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>