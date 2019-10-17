<?php

require 'vendor/autoload.php';
use Jakopec\Osoba;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

Flight::route('/', function(){
    $poruka=new stdClass();
    $poruka->poruka="Nepotpuni zahtjev";
    $poruka->kod=1;
    $poruka->detalji="https://upute.app.hr/blog/api/v1/greske/7";

    $odgovor=new stdClass();
    $odgovor->greska=[$poruka];

    Flight::json($odgovor);

});

Flight::route('GET /osobe', function(){
    
    $osoba = new Osoba();

    Flight::json($osoba->getOsobe());

});

Flight::route('POST /osobe', function(){
    
    $osoba = new Osoba();
    
    $poruka=new stdClass();
    $poruka->poruka=$osoba->dodaj(Flight::request()->data);

    $odgovor=new stdClass();
    $odgovor->greska=[$poruka];
    
    Flight::json($odgovor); 
    
    header("HTTP/1.1 201 Created"); //https://gist.github.com/phoenixg/5326222

});



Flight::start();