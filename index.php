<?php
//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//start a session
session_start();

//Require autoload file
require_once("vendor/autoload.php");

//Instantiate F3 Base class
$f3 = Base::instance();

//Define a default route (328/diner/)
//anonymous function--not named function
$f3->route('GET /', function(){
    //echo '<h1>My Diner</h1>';
    $view = new Template();
    echo $view->render('views/diner-home.html');
});
//Define a default route (328/diner/breakfast)
$f3->route('GET /breakfast', function(){
    //echo '<h1>My Diner</h1>';
    $view = new Template();
    echo $view->render('views/breakfast.html');
});
//Define a default route (328/diner/lunch)
$f3->route('GET /lunch', function(){
    //echo '<h1>My Diner</h1>';
    $view = new Template();
    echo $view->render('views/lunch.html');
});

//order1 route -> views/order-form1.html
$f3->route('GET|POST /order1', function(){
//FI THE FORM HAS BEEN SUBMITTED
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    $view = new Template();
    echo $view->render('views/order-form1.html');
});

$f3->route('GET /summary', function(){
    //echo '<h1>My Diner</h1>';
    $view = new Template();
    echo $view->render('views/order-summary.html');
});
//Run fat free
$f3->run();

?>