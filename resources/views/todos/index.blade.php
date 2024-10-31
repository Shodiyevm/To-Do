<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

    <!-- Container -->
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold text-center text-purple-600 mb-8">To-Do List</h1>

        <!-- Add Task Form -->
        <form action="/todos" method="POST" class="bg-white shadow-lg rounded-lg p-8 mb-6">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-800 text-sm font-bold mb-2" for="title">Task Title</label>
                <input type="text" name="title" id="title" placeholder="Enter task title" class="shadow border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-800 text-sm font-bold mb-2" for="description">Task Description</label>
                <input type="text" name="description" id="description" placeholder="Enter task description" class="shadow border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline">
                Add Task
            </button>
        </form>

        <!-- To-Do List -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            @foreach($todos as $todo)
                <div class="flex items-center justify-between mb-4 p-4 border-b border-gray-300">
                    <div>
                        <h3 class="text-xl font-semibold {{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">{{ $todo->title }}</h3>
                        <p class="text-gray-600">{{ $todo->description }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Mark as Completed/Incomplete -->
                        <form action="/todos/{{ $todo->id }}/toggle" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs font-semibold {{ $todo->completed ? 'bg-yellow-400 hover:bg-yellow-500' : 'bg-green-500 hover:bg-green-600' }} text-white py-1 px-2 rounded-lg transition">
                                {{ $todo->completed ? 'Mark Incomplete' : 'Mark Complete' }}
                            </button>
                        </form>
                        
                        <!-- Edit Button -->
                        <button onclick="openEditModal({{ $todo->id }}, '{{ $todo->title }}', '{{ $todo->description }}')" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold py-1 px-2 rounded-lg transition">
                            Edit
                        </button>
                        
                        <!-- Delete Button -->
                        <form action="/todos/{{ $todo->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold py-1 px-2 rounded-lg transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Edit Task</h2>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="editTitle" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" id="editTitle" name="title" class="shadow border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                </div>
                <div class="mb-4">
                    <label for="editDescription" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <input type="text" id="editDescription" name="description" class="shadow border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    Save Changes
                </button>
                <button type="button" onclick="closeEditModal()" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    Cancel
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
