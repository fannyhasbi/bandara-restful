<?php
require 'flight/Flight.php';
require './api.php';

$api = new Api();

Flight::route('GET /', function(){
    Flight::render('home.php');
});

Flight::route('GET /bandara', [$api, 'bandara']);
Flight::route('POST /bandara', [$api, 'tambah_bandara']);
Flight::route('POST /bandara-update', [$api, 'update_bandara']);
Flight::route('POST /bandara-delete', [$api, 'delete_bandara']);

Flight::route('GET /pesawat', [$api, 'pesawat']);
Flight::route('POST /pesawat', [$api, 'tambah_pesawat']);
Flight::route('POST /pesawat-update', [$api, 'update_pesawat']);
Flight::route('POST /pesawat-delete', [$api, 'delete_pesawat']);

Flight::route('GET /takeoff', [$api, 'takeoff']);

Flight::route('GET /landing', [$api, 'landing']);

Flight::route('GET *', function(){
  Flight::redirect('/');
});

Flight::start();
