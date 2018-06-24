<?php

namespace ProdeIAW\Observer;

use ProdeIAW\Grupo;
use ProdeIAW\Equipo;

class GrupoObserver{
    public function deleting(Grupo $grupo)
    {
        foreach ($grupo->equipos as $key => $value) {
            $grupo->equipos()->detach($value);
        }
    }
}