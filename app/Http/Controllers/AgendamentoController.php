<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Servico;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index() {
        $agendamentos = Agendamento::where('cliente_id', Auth::id())->get();
        return view('agendamento.index', compact("agendamentos"));
    }

    public function create()
    {

        $barbeiros = User::where('role', 'admin')->get();
        $servicos = Servico::all();
        
        return view('agendamento.create', compact(['barbeiros', 'servicos']));
    }

    public function store(Request $request)
    {   
        $data = $request->all();
        $data['cliente_id'] = Auth::id();
        Agendamento::create($data);
        return redirect('/agendamento')->with('success', 'Agendamento realizado com sucesso!');
    }

    public function cancelar($id)
    {
        $agendamento = Agendamento::findOrFail($id);

       
        if ($agendamento->cliente_id != Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }
    
        $agendamento->status = false;
        $agendamento->save();
    

        return redirect('/agendamento')->with('success', 'Agendamento cancelado com sucesso!');
    }

    public function confirmar($id)
    {
        $agendamento = Agendamento::findOrFail($id);

       
        if ($agendamento->cliente_id != Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }
    
        $agendamento->status = true;
        $agendamento->save();
    

        return redirect('/agendamento')->with('success', 'Agendamento confirmado com sucesso!');
    }
}
