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
        return view("agendamento.create");
    }

    public function store()
    {
       
    }
}
