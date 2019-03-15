<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Item;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function index()
    { 
        return view('todos.index', ['todos' => Todo::orderBy('id', 'desc')->get()]);        
    } 

    public function getItemsByTodo(Todo $todo)
    {  
        if(!$items = Item::where('todo_id', $todo->id)->orderBy('id', 'desc')->get())
            return response()->json(['msg' => 'Error while reading items!'], 400); 
        return response()->json(['data' => $items, 'msg' => 'Items was read successfully!'], 200);        
    } 
   
    public function show(Todo $todo)
    {
        return view('todos.show', ['data' => 'todos.show !']); 
    } 
        
    public function store(Request $request)
    { 
        $t = new Todo();
        if (!$t->validate($request->all())) 
            return response()->json(['msg' => $t->errors()], 422);
            
        if(!$todo = Todo::add($request->all()))
            return response()->json(['msg' => 'Error while adding the todo!'], 400); 
        return response()->json(['data' => $todo, 'msg' => 'The todo list was succussfully added!'], 200); 
    }
    
    public function update(Request $request, Todo $todo)
    {
        //
    }

    public function destroy(Todo $todo)
    {  
        $todo->_items()->delete();
        if(!$todo->delete())
            return response()->json(['msg' => 'Error while deleting the todo!'], 400); 
        
        return response()->json(['data' => $todo, 'msg' => 'The todo list was succussfully deleted!'], 200); 
    }
}
