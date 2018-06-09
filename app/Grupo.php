<?php

namespace ProdeIAW;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table 		= 'grupos';
    protected $primaryKey 	= 'id';
    public $timestamps 		= false;
    public $incrementing = false;



    protected $fillable		= [
    	'nombre',
    	'descripcion',
    ];



    protected $guarder		= [
    ];

    public function torneo()
    {
        return $this->belongsTo('ProdeIAW\Torneo');
    }


    public function equipos()
    {
        return $this->belongsToMany('ProdeIAW\Equipo','participa');
    }
}
