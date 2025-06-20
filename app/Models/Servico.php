<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_servico',
        'descricao',
        'valor',
        'valor_fim_semana',
        'duracao_minutos'
    ];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'servico_id');
    }
}
