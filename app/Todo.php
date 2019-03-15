<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Todo extends Model
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

    public function create($request)
    {
        $this->title = $request['title']; 
        $this->save();
        return $this; 
    }

    public static function add($request)
    { 
        $todo = new Todo();
        return $todo->create($request);
    }
    /********************** RELATIONSHIPS **********************/
    public function _items()
    {
        return $this->hasMany(Item::class);
    }
}
