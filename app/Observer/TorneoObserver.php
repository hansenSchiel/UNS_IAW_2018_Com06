<?php

namespace ProdeIAW\Observer;

use ProdeIAW\Torneo;
use ProdeIAW\Equipo;
use ProdeIAW\Grupo;
use ProdeIAW\Encuentro;
use ProdeIAW\Fecha;

class TorneoObserver{
    public function deleting(Torneo $torneo)
    {
        foreach ($torneo->grupos as $key => $value) {
            $value->delete();
        }
        foreach ($torneo->fechas as $key => $value) {
            $value->delete();
        }
        foreach ($torneo->encuentros as $key => $value) {
            $value->delete();
        }
    }
}