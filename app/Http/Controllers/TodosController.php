<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function index()
    { 
        return view('todos.index', ['todos' => Todo::all()]);        
    } 
   
    public function show(Todo $todo)
    {
        return view('todos.show', ['data' => 'todos.show !']); 
    } 
        
    public function store(Request $request)
    {
        //
    }
    
    public function update(Request $request, Todo $todo)
    {
        //
    }

    public function destroy(Todo $todo)
    {
        //
    }
}
