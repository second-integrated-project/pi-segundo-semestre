<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pacote;

class PacoteController extends Controller
{
    public function index()
    {
        $pacotes = Pacote::all();
        return view("admin.pacotes.index", compact("pacotes"));
    }

    public function create()
    {
        return view("admin.pacotes.create");
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Pacote::create($data);
        return redirect('/pacotes')->with('success', 'Item cadastrado com sucesso!');
    }

    public function edit(Pacote $pacote)
    {
        return view('admin.pacotes.edit', compact('pacote'));
    }

    public function update(Request $request, Pacote $pacote)
    {
        $data = $request->all();
        $pacote->update($data);
        return redirect('/pacotes')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(Pacote $pacote)
    {
        $pacote->delete();
        return redirect('/pacotes')->with('success', 'Item deletado com sucesso!');
    }

    public function adquirirPacote($pacoteId)
    {
        $user = auth()->user();

        $pacote = Pacote::findOrFail($pacoteId);

        $user->pacotes()->syncWithoutDetaching([$pacote->id]);

        return redirect()->route('admin.pacotes.index')
            ->with('success', 'Plano adquirido com sucesso!');
    }

    public function cancelarPacote($pacoteId)
{
    $user = auth()->user();

    $user->pacotes()->detach($pacoteId);

    return redirect()->route('admin.pacotes.index')
                     ->with('success', 'Plano cancelado com sucesso!');
}

}
