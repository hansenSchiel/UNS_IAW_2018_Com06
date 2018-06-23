<?php

namespace ProdeIAW\Observer;

use ProdeIAW\Participacion;

class ParticipacionObserver{
    public function deleting(Participacion $participacion)
    {
        echo "<br>Borrando participacion ".$participacion->user->nombre;
        foreach ($participacion->pronosticos as $key => $value) {
            $value->delete();
        }
    }
}