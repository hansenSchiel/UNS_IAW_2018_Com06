<?php

namespace ProdeIAW;

use Illuminate\Database\Eloquent\Model;

class Encuentro extends Model
{
    
    protected $table 		= 'Encuentros';
    protected $primaryKey 	= 'id';
    public $timestamps 		= false;
    public $incrementing = false;
    protected $fillable		= [
    	'ident',
    	'dia',
    	'puntosL',
    	'puntosV'
    ];


    public function equipoL()
    {
        return $this->belongsTo('ProdeIAW\Equipo','equipoL');
    }

    public function equipoV()
    {
        return $this->belongsTo('ProdeIAW\Equipo','equipoV');
    }

    public function torneo()
    {
        return $this->belongsTo('ProdeIAW\Torneo','torneo');
    }
}
