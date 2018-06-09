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
    	'fechaFin'
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
        return $this->belongsToMany('ProdeIAW\Encuentro','participa');
    }
}
