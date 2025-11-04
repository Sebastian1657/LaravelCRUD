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
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                <h2 class="text-4xl font-bold text-white flex items-center justify-between">
                    Zadania
                    <button class="bg-white text-indigo-600 px-5 py-2 rounded-lg font-large hover:bg-indigo-50 transition">
                        + Dodaj zadanie
                    </button>
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <input type="checkbox" class="rounded">
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Nazwa zadania</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Akcje</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
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
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <span>Pokazuje <strong>0</strong> z <strong>0</strong> zadań</span>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Poprzednia</button>
                        <button class="px-3 py-1 bg-indigo-600 text-white rounded">1</button>
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Następna</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>