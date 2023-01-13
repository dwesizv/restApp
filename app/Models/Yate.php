<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yate extends Model
{
    use HasFactory;
    
    protected $table = 'yate';
    
    protected $fillable = [
                    'iduser',
                    'idastillero',
                    'idtipo',
                    'nombre',
                    'descripcion',
                    'precio'
                ];

}