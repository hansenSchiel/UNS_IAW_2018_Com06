<?php

namespace ProdeIAW;

use Illuminate\Database\Eloquent\Model;

class Encuentro extends Model
{
    
    protected $table 		= 'encuentros';
    protected $primaryKey 	= 'id';
    public $timestamps 		= false;
    public $incrementing = false;
    protected $fillable		= [
    	'ident',
    	'dia',
        'fecha',
    	'puntosL',
    	'puntosV'
    ];


    public function equipoL()
    {
        return $this->belongsTo('ProdeIAW\Equipo','equipoL_id');
    }

    public function equipoV()
    {
        return $this->belongsTo('ProdeIAW\Equipo','equipoV_id');
    }

    public function torneo()
    {
        return $this->belongsTo('ProdeIAW\Torneo');
    }
    public function fechaO()
    {
        return $this->belongsTo('ProdeIAW\Fecha');
    }

    public function pronosticos()
    {
        return $this->hasMany('ProdeIAW\Pronostico');
    }
}
