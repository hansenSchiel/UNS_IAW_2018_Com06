<?php

namespace ProdeIAW;

use Illuminate\Database\Eloquent\Model;

class Participacion extends Model
{
    
    protected $table 		= 'participacion';
    protected $primaryKey 	= 'id';
    public $timestamps 		= false;
    public $incrementing = false;


    protected $fillable		= [];



    public function user()
    {
        return $this->belongsTo('ProdeIAW\User');
    }
    public function fecha()
    {
        return $this->belongsTo('ProdeIAW\Fecha');
    }
    public function pronosticos()
    {
        return $this->hasMany('ProdeIAW\Pronostico');
    }
}
