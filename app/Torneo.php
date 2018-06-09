<?php

namespace ProdeIAW;

use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    protected $table 		= 'torneos';
    protected $primaryKey 	= 'id';
    public $timestamps 		= false;
    public $incrementing = false;


    protected $fillable		= [
    	'nombre',
    	'descripcion',
    	'condicion',
    	'fechaInicio',
    	'fechaFin',
        'deporte'
    ];

    protected $guarder		= [
    ];


    public function grupos()
    {
        return $this->hasMany('ProdeIAW\Grupo');
    }
    public function fechas()
    {
        return $this->hasMany('ProdeIAW\Fecha');
    }
    public function encuentros()
    {
        return $this->hasMany('ProdeIAW\Encuentro','torneo');
    }
}
