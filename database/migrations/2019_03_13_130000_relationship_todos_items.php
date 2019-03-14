<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipTodosItems extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table){
            $table->unsignedInteger('todo_id')->after('id'); 
            $table->foreign('todo_id')
                    ->references('id')
                    ->on('todos');
        });
    } 
    
    public function down()
    {
        Schema::table('items', function (Blueprint $table){
            $table->dropForeign(['todo_id']);
        });
    }
}
