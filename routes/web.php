<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ServicoController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

Route::get('/servicos', [ServicoController::class, 'index'])->name('admin.servicos.index');

Route::get('/contato', function () {
    return view('contato');
})->name('contato');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    route::get('admin/dashboard', [HomeController::class,'index'])->name('admin.dashboard');
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
});

require __DIR__.'/auth.php';

