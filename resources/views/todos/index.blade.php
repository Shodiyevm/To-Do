<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список дел</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600&display=swap" rel="stylesheet">
    <img src="/images/todo-logo.png" alt="To-Do Logo" class="w-16 h-16 mr-2">
</head>
<body class="bg-gray-100 font-sans">

    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold text-center text-purple-600 mb-8">Список дел</h1>

        <div class="flex justify-between mb-6">
            @if (!auth()->check())
                <a href="/login" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    Вход
                </a>
                <a href="/register" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    Регистрация
                </a>
            @else
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                        Выход
                    </button>
                </form>
            @endif
        </div>

        <form action="/todos" method="POST" class="bg-white shadow-lg rounded-lg p-8 mb-6">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-800 text-sm font-bold mb-2" for="title">Название задачи</label>
                <input type="text" name="title" id="title" placeholder="Введите название задачи" class="shadow border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500" required>
            </div>
          
            <div class="mb-4">
                <label class="block text-gray-800 text-sm font-bold mb-2" for="description">Описание задачи</label>
                <input type="text" name="description" id="description" placeholder="Введите описание задачи" class="shadow border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline">
                Добавить задачу
            </button>
        </form>

        <div class="bg-white shadow-lg rounded-lg p-6">
            @foreach($todos as $todo)
                <div class="flex items-center justify-between mb-4 p-4 border-b border-gray-300">
                    <div>
                        <h3 class="text-xl font-semibold {{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">{{ $todo->title }}</h3>
                        <p class="text-gray-600">{{ $todo->description }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <form action="/todos/{{ $todo->id }}/toggle" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs font-semibold {{ $todo->completed ? 'bg-yellow-400 hover:bg-yellow-500' : 'bg-green-500 hover:bg-green-600' }} text-white py-1 px-2 rounded-lg transition">
                                {{ $todo->completed ? 'Отметить как невыполненное' : 'Отметить как выполненное' }}
                            </button>
                        </form>
                        
                        <button onclick="openEditModal({{ $todo->id }}, '{{ $todo->title }}', '{{ $todo->description }}')" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold py-1 px-2 rounded-lg transition">
                            Редактировать
                        </button>
                        
                        <form action="/todos/{{ $todo->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold py-1 px-2 rounded-lg transition">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Редактировать задачу</h2>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="editTitle" class="block text-gray-700 text-sm font-bold mb-2">Название</label>
                    <input type="text" id="editTitle" name="title" class="shadow border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                </div>
                <div class="mb-4">
                    <label for="editDescription" class="block text-gray-700 text-sm font-bold mb-2">Описание</label>
                    <input type="text" id="editDescription" name="description" class="shadow border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    Сохранить изменения
                </button>
                <button type="button" onclick="closeEditModal()" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    Отмена
                </button>
            </form>
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function openEditModal(id, title, description) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
            document.getElementById('editForm').action = `/todos/${id}`;
        }
        
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>
