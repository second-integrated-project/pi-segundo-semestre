<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'cliente_id',
        'barbeiro_id',
        'horario_disponivel',
        'servico_id'
    ];

    public function barbeiro()
    {
        return $this->belongsTo(User::class, 'barbeiro_id');
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'servico_id');
    }
}
