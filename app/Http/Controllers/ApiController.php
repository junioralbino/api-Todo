<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Todo;

class ApiController extends Controller
{
    public function createTodo(Request $request){
       $array = ['error'=>''];
       
        //validado os dados enviados
        $rules = [
            'title' => 'required|min:3'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
          $array['error'] = $validator->message();

          return $array;
        }
        $title = $request->input('title');

        //usado o models inserir os dados
        $todo = new Todo();
        $todo->title = $title;
        $todo->save();
    
        return $array;
    }
    public function readAllTodo(){
        $array = ['error'=>''];
         
        $todo = Todo::simplePaginate(2);

        $array['list'] = $todo->items();

        $array['current_page'] = $todo->currentPage();


        return $array;
    }
    public function readTodo($id){
        $array = ['error'=>''];

        $todo = Todo::find($id);

        if($todo){
          $array['todo'] = $todo;
        }else{
            $array['error'] = 'A tarefa'.$id.'nao existe';
        }

        return $array;
    }
    public function updateTodo($id, Request $request){
        $array = ['error'=>''];

              
        //validado os dados enviados
        $rules = [
            'title' => 'min:3',
            'done' => 'boolean' 
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
          $array['error'] = $validator->message();

          return $array;
        }
        $title = $request->input('title');
        $done = $request->input('done');
        
        //atualizar dados da tarefa
        $todo = Todo::find($id);

        if($todo){
            if($title){
                $todo->title = $title;
            }
            if($done !== NULL){
                $todo->done = $done;
            }
            $todo->save();

        }else{
            $array['error'] = 'A tarefa'.$id.'nao encontrada';
        }

        return $array;
    }
    public function deleteTodo($id){
        $array = ['error'=>''];

        $todo = Todo::find($id);

        if($todo){
          $todo->delete();
        }else{
            $array['error'] = 'Essa tarefa'.$id.'nao existe para ser deletar';
        }
       

        return $array;
        
    }
}
