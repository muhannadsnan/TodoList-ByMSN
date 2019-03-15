<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Item extends Model
{
    protected $guarded = [];
    private $errors;

    private $rules = [ // Validation rules
        'title'  => 'required|min:2',
    ];

    public function validate($data)
    { 
        $v = Validator::make($data, $this->rules);         
        if ($v->fails()) { // check for failure
            $this->errors = $v->errors();
            return false;
        }        
        return true; // validation pass
    }

    public function errors()
    {
        return $this->errors;
    } 

    public static function addObj($request)
    {
        $item = new Item(); 
        $item->title = $request['title']; 
        $item->complete = $request['complete']; 
        $item->todo_id = $request['todo_id']; 
        $item->save();
        return $item; 
    }

    public function editObj($request)
    { 
        $item = Item::find($request['id']); 
        $item->title = $request['title']; 
        $item->complete = $request['complete'];   
        $item->save();
        return $item;
    }

    public static function updateObj($request)
    {
        $item = new Item(); 
        return $item->editObj($request);
    }
    /********************** RELATIONSHIPS **********************/
    public function _todo() 
    {
        return $this->belongsTo(Todo::class, 'todo_id');
    }
}
