<?php

require 'vendor/autoload.php';
use Jakopec\Osoba;

Flight::route('GET /osobe', function(){
    
    $osoba = new Osoba();

    Flight::json($osoba->getOsobe());

});

Flight::route('POST /osobe', function(){
    
    $osoba = new Osoba();
    
    $poruka=new stdClass();
    $poruka->tekst=$osoba->dodaj(Flight::request()->data);
    $poruka->greska=false;
    $odgovor=new stdClass();
    $odgovor->poruka=$poruka;
    
    Flight::json($odgovor); 

    header("HTTP/1.1 201 Created"); //https://gist.github.com/phoenixg/5326222

});

Flight::route('/', function(){
    $poruka=new stdClass();
    $poruka->tekst="Nepotpuni zahtjev";
    $poruka->kod=1;
    $poruka->greska=true;
    $poruka->detalji="https://upute.app.hr/blog/api/v1/greske/7";

    $odgovor=new stdClass();
    $odgovor->poruka=$poruka;

    Flight::json($odgovor);

});



Flight::start();