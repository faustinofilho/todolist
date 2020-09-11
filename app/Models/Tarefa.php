<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = [
        'projeto_id',
        'titulo',
        'descricao',
        'date_conclusion'
    ];

}
