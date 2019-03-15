<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{    
    public function store(Request $request)
    {
        $t = new Item();
        if (!$t->validate($request->all()))
            return response()->json(['msg' => $t->errors()], 422);

        if(!$item = Item::addObj($request->all()))
            return response()->json(['msg' => 'Error while adding the item!'], 400); 
        return response()->json(['data' => $item, 'msg' => 'The item was succussfully added!'], 200);
    } 
    
    public function update(Request $request, Item $item)
    { 
        $t = new Item();
        if (!$t->validate($request->all()))
            return response()->json(['data' => $item, 'msg' => $t->errors()], 422);

        if(!$item = Item::updateObj($request->all()))
            return response()->json(['msg' => 'Error while editing the item!'], 400);  
        return response()->json(['data' => $item, 'msg' => 'The item was succussfully edited!'], 200);
    }
    
    public function destroy(Item $item)
    {
        if(!$item->delete())
            return response()->json(['msg' => 'Error while deleting the item!'], 400); 
        return response()->json(['data' => $item, 'msg' => 'The item was succussfully deleted!'], 200); 
    }
}
