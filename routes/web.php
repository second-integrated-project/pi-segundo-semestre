<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\PacoteController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContatoController;

// Rotas Públicas


Route::group([], function () {

    Route::get('/', function () {
        return view('home');
    });

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/sobre', function () {
        return view('sobre');
    })->name('sobre');

    Route::get('/contato', [ContatoController::class, 'index'])->name('contato');

    Route::get('/servicos', [ServicoController::class, 'index'])->name('admin.servicos.index');

    Route::get('/pacotes', [PacoteController::class, 'index'])->name('admin.pacotes.index');

});

// Rotas que precisam de autenticação


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas que precisam de autenticação e role 'user'


Route::middleware(['auth', 'user'])->group(function () {
    route::get('/agendamento', [AgendamentoController::class, 'index'])->name('agendamento.index');
    Route::get('/agendamento/create', [AgendamentoController::class, 'create'])->name('agendamento.create');
    Route::post('/agendamento', [AgendamentoController::class, 'store'])->name('agendamento.store');
    Route::post('agendamento/cancelar/{id}', [AgendamentoController::class, 'cancelar'])->name('agendamento.cancelar');
    Route::post('agendamento/confirmar/{id}', [AgendamentoController::class, 'confirmar'])->name('agendamento.confirmar');
    Route::get('/agendamento/horarios-disponiveis', [AgendamentoController::class, 'horariosDisponiveis']);
    Route::post('/pacotes/adquirir/{id}', [PacoteController::class, 'adquirirPacote'])->name('pacotes.adquirir');
    Route::post('/pacotes/cancelar/{id}', [PacoteController::class, 'cancelarPacote'])->name('pacotes.cancelar');

});

// Rotas que precisam de autenticação e role 'admin'


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/inventario', [InventarioController::class, 'index'])->name('admin.inventario.index');
    Route::get('admin/inventario/create', [InventarioController::class, 'create'])->name('admin.inventario.create');
    Route::post('admin/inventario/store', [InventarioController::class, 'store'])->name('admin.inventario.store');
    Route::get('admin/inventario/edit/{inventario}', [InventarioController::class, 'edit'])->name('admin.inventario.edit');
    Route::patch('admin/inventario/edit/{inventario}', [InventarioController::class, 'update'])->name('admin.inventario.update');
    Route::delete('admin/inventario/destroy/{inventario}', [InventarioController::class, 'destroy'])->name('admin.inventario.destroy');
    Route::get('admin/servicos/create', [ServicoController::class, 'create'])->name('admin.servicos.create');
    Route::post('admin/servicos/store', [ServicoController::class, 'store'])->name('admin.servicos.store');
    Route::get('admin/servicos/edit/{servico}', [ServicoController::class, 'edit'])->name('admin.servicos.edit');
    Route::patch('admin/servicos/edit/{servico}', [ServicoController::class, 'update'])->name('admin.servicos.update');
    Route::delete('admin/servicos/destroy/{servico}', [ServicoController::class, 'destroy'])->name('admin.servicos.destroy');

    Route::get('admin/pacotes/create', [PacoteController::class, 'create'])->name('admin.pacotes.create');
    Route::post('admin/pacotes/store', [PacoteController::class, 'store'])->name('admin.pacotes.store');
    Route::get('admin/pacotes/edit/{pacote}', [PacoteController::class, 'edit'])->name('admin.pacotes.edit');
    Route::patch('admin/pacotes/edit/{pacote}', [PacoteController::class, 'update'])->name('admin.pacotes.update');
    Route::delete('admin/pacotes/destroy/{pacote}', [PacoteController::class, 'destroy'])->name('admin.pacotes.destroy');

    Route::post('/agendamento/{id}/status', [AgendamentoController::class, 'updateStatus'])->name('admin.agendamentos.updateStatus');

    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('admin/users/{user}/toggle', [UserController::class, 'toggleActive'])->name('admin.users.toggle');
    Route::patch('admin/users/{user}/role', [UserController::class, 'changeRole'])->name('admin.users.role');
});

require __DIR__ . '/auth.php';