<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pacote extends Model
{
    protected $fillable = [
        'nome_pacote',
        'descricao',
        'valor'
    ];
}
