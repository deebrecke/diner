<?php
//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once("vendor/autoload.php");

//start a session
session_start();
//var_dump($_SESSION);
//require_once ('model/data-layer.php');
//require_once('model/validate.php');
//require_once ('classes/order.php');
/*
$myOrder = new Order();
$myOrder->setFood("sushi");
echo $myOrder->getFood();
$myOrder->setMeal("dinner");
echo $myOrder->getMeal();
$myOrder->setCondiments("ginger");
echo $myOrder->getCondiments();
var_dump($myOrder);
//var_dump(getMeals());
*/
//Instantiate F3 Base class
$f3 = Base::instance();

//instantiate a controller object
$con = new Controller($f3);

//Define a default route (328/diner/)
//anonymous function--not named function
$f3->route('GET /', function(){
    $GLOBALS['con']->default();
});

//Define a breakfast route (328/diner/breakfast)
$f3->route('GET /breakfast', function(){
    $view = new Template();
    echo $view->render('views/breakfast.html');
});
//Define a lunch route (328/diner/lunch)
$f3->route('GET /lunch', function(){
    $view = new Template();
    echo $view->render('views/lunch.html');
});

//Define an order1 route (328/diner/order1)
$f3->route('GET|POST /order1', function($f3) {
    $GLOBALS['con']->order1();
});

//Define an order2 route (328/diner/order2)
$f3->route('GET|POST /order2', function($f3) {
    $GLOBALS['con']->order2();
});

$f3->route('GET /summary', function(){
    $GLOBALS['con']->summary();
});

//Run fat free
$f3->run();

