<?php
require 'flight/Flight.php';

Flight::route('/', function(){
    Flight::render('home.php');
});

Flight::start();
