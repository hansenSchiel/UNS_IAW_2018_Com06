<?php

namespace ProdeIAW\Observer;

use ProdeIAW\Participacion;

class ParticipacionObserver{
    public function deleting(Participacion $participacion)
    {
        foreach ($participacion->pronosticos as $key => $value) {
            $value->delete();
        }
    }
}