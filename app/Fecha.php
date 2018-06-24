<?php

namespace ProdeIAW;

use Illuminate\Database\Eloquent\Model;

class Fecha extends Model
{
    protected $table 		= 'fechas';
    protected $primaryKey 	= 'id';
    public $timestamps 		= false;
    public $incrementing = false;



    protected $fillable		= [
    	'fechaInicio',
    	'fechaFin',
        'nombre',
        'tipo'
    ];

    public function torneo()
    {
        return $this->belongsTo('ProdeIAW\Torneo');
    }
    public function ganador()
    {
        return $this->belongsTo('ProdeIAW\User');
    }

    public function encuentros()
    {
        return $this->hasMany('ProdeIAW\Encuentro');
    }
    public function participaciones()
    {
        return $this->hasMany('ProdeIAW\Participacion');
    }
}
