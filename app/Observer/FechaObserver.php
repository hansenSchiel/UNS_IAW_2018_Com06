<?php

namespace ProdeIAW\Observer;

use ProdeIAW\Fecha;
use ProdeIAW\Equipo;
use ProdeIAW\Grupo;
use ProdeIAW\Encuentro;

class FechaObserver{
    public function deleting(Fecha $fecha)
    {
        echo "<br>Borrando fecha ".$fecha->nombre;
        foreach ($fecha->encuentros as $key => $value) {
            $value->delete();
        }
        foreach ($fecha->participaciones as $key => $value) {
            $value->delete();
        }
    }
}