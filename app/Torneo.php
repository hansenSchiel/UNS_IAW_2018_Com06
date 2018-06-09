<?php

namespace ProdeIAW;

use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    protected $table 		= 'torneo';
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
}
