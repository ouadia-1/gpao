<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OF extends Model
{
    use HasFactory;

    protected $table = 'o_f_s';
    protected $primaryKey = 'numero_of';

    protected $fillable = [
        'numero_of', 'client', 'designation', 'qte', 'caracteristiques', 'etat'
    ];
}
