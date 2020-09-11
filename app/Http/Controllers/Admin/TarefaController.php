<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarefa;

class TarefaController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Tarefa::updateOrCreate(
            ['id' => $request['id']], 
            $request->all()
        );

        return response()->json(['success' => true, 'todo'=> $this->myTaskTodo($request->projeto_id), 'done'=> $this->myTaskDone($request->projeto_id)]);
    }

    public function myTaskTodo($id)
    {
        $todos = Tarefa::whereNull('date_conclusion')->where('projeto_id', $id)->get();
        return $todos;
    }

    public function myTaskDone($id)
    {
        $dones = Tarefa::whereNotNull('date_conclusion')->where('projeto_id', $id)->get();
        return $dones;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projeto = Tarefa::find($id);
        
        Tarefa::find($id)->delete($id); 

        return response()->json(['success' => true, 'todo'=> $this->myTaskTodo($projeto->projeto_id), 'done'=> $this->myTaskDone($projeto->projeto_id)]);
    }

    public function conclusion($id)
    {
        $task = Tarefa::find($id);
        $task->date_conclusion = date('Y-m-d H:i:s');
        $task->save();
        
        return response()->json(['success' => true, 'todo'=> $this->myTaskTodo($task->projeto_id), 'done'=> $this->myTaskDone($task->projeto_id)]);
    }
}
