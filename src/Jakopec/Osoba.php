<?php

namespace Jakopec;

use stdClass;

class Osoba
{

    public function getOsobe()
    {

        $osobe=[];
        //dovući iz baze kasnije
        for($i=0;$i<10;$i++){
            $o = new stdClass();
            $o->ime="Ime" . $i;
            $o->prezime="Prezime " . $i;
            $osobe[]=$o; 
        }

        return $osobe;
    }


    public function dodaj($osoba)
    {
        return "dodao " . $osoba->ime . " " . $osoba->prezime;
    }
    
}