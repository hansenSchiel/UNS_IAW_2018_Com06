<?php

namespace ProdeIAW;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table 		= 'equipos';
    protected $primaryKey 	= 'id';
    public $timestamps 		= false;
    public $incrementing = false;
    protected $fillable		= [
    	'nombre',
    	'descripcion',
    	'condicion'
    ];

    protected $guarder		= [
    ];


    public function grupos()
    {
        return $this->belongsToMany('ProdeIAW\Grupo','participa');
    }

}
