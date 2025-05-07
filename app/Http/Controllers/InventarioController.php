<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::all();
        return view("admin.inventario.index", compact("inventarios"));
    }

    public function create()
    {
        return view("admin.inventario.create");
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Inventario::create($data);
        return redirect('inventario')->with('success', 'Item cadastrado com sucesso!');
    }

    public function edit(Inventario $inventario)
    {
        return view('admin.inventario.edit', compact('inventario'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $data = $request->all();
        $inventario->update($data);
        return redirect('inventario')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect('inventario')->with('success', 'Item deletado com sucesso!');
    }
}
