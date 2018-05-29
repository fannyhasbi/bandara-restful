<?php
require 'flight/Flight.php';
require './api.php';

$api = new Api();

Flight::route('GET /', function(){
    Flight::render('home.php');
});

Flight::route('GET /api/bandara', [$api, 'bandara']);
Flight::route('POST /api/bandara', [$api, 'tambah_bandara']);

Flight::route('GET /api/pesawat', [$api, 'pesawat']);

Flight::route('GET /api/takeoff', [$api, 'takeoff']);

Flight::route('GET /api/landing', [$api, 'landing']);

Flight::route('GET *', function(){
  Flight::redirect('/');
});

Flight::start();
