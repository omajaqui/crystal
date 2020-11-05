<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Añadimos la clase JWTSubject 
use Tymon\JWTAuth\Contracts\JWTSubject;

class test extends Model implements JWTSubject
{
    //use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    //protected $connection = 'connection-name';

    protected $table = 'login';
    protected $primaryKey = 'idLogin';

    protected $fillable = [
        'idLogin',
        'nombres',
        'documento',
        'usuario',
        'pass',
        'fechaCreacion',
        'fechaActualizacion',
        'idEstado'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

}
