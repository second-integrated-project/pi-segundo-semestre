<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servico;

class ServicoController extends Controller
{
    public function index()
    {
        $servicos = Servico::all();
        return view("admin.servicos.index", compact("servicos"));
    }

    public function create()
    {
        return view("admin.servicos.create");
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Servico::create($data);
        return redirect('/servicos')->with('success', 'Item cadastrado com sucesso!');
    }

    public function edit(Servico $servico)
    {
        return view('admin.servicos.edit', compact('servico'));
    }

    public function update(Request $request, Servico $servico)
    {
        $data = $request->all();
        $servico->update($data);
        return redirect('/servicos')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(Servico $servico)
    {
        $servico->delete();
        return redirect('/servicos')->with('success', 'Item deletado com sucesso!');
    }
}
