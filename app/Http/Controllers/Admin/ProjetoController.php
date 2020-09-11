<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Projeto;
use App\Models\Tarefa;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('admin.projeto.index', ['projetos'=> $this->myProject()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['user_id'] = \Auth::id();

        Projeto::updateOrCreate(
            ['id' => $request['id']], 
            $request->all()
        );

        return response()->json(['success' => true, 'projetos'=> $this->myProject()]);
    }

    public function myProject()
    {
        $projeto = Projeto::where('user_id', \Auth::id())->get();
        return $projeto;
    }


    public function edit(Projeto $projeto)
    {
        $todos = Tarefa::whereNull('date_conclusion')->where('projeto_id', $projeto->id)->get();
        $dones = Tarefa::whereNotNull('date_conclusion')->where('projeto_id', $projeto->id)->get();
        return view('admin.projeto.edit', compact('projeto', 'todos', 'dones'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Projeto::find($id)->delete($id);
        Tarefa::where('projeto_id', $id)->delete();

        return response()->json(['success' => true, 'projetos'=> $this->myProject()]);
    }
}
