<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', auth()->user()->id)->get();
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $user=auth()->user()->id;
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description, 
            'user_id' => $user,
            'completed' => false,
        ]);

        return redirect('/')->with('Успешно');
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]));

        return redirect('/')->with('Успешно');
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect('/')->with('Успешно');
    }

    public function toggle($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->completed = !$todo->completed;
        $todo->save();

        return redirect('/')->with('Успешно');
    }
}
