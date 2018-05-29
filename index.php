<?php
require 'flight/Flight.php';
require './api.php';

$api = new Api();

Flight::route('GET /', function(){
    Flight::render('home.php');
});

Flight::route('GET /api/bandara', [$api, 'bandara']);

Flight::route('GET *', function(){
  Flight::redirect('/');
});

Flight::start();
