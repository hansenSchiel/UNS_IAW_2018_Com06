<?php

namespace ProdeIAW;

use Illuminate\Database\Eloquent\Model;

class Pronostico extends Model
{
    protected $table 		= 'pronostico';
    protected $primaryKey 	= 'id';
    public $incrementing = false;


    protected $fillable		= [
    	'ganador',
    ];


    public function encuentro()
    {
        return $this->belongsTo('ProdeIAW\Encuentro');
    }
    public function participacion()
    {
        return $this->belongsTo('ProdeIAW\Participacion');
    }
}
