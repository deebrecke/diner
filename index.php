<?php
//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//start a session
session_start();

//Require autoload file
require_once("vendor/autoload.php");
require_once ('model/data-layer.php');
//var_dump(getMeals());

//Instantiate F3 Base class
$f3 = Base::instance();

//Define a default route (328/diner/)
//anonymous function--not named function
$f3->route('GET /', function(){
    //echo '<h1>My Diner</h1>';
    $view = new Template();
    echo $view->render('views/diner-home.html');
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

$f3->route('GET /summary', function(){
    $view = new Template();
    echo $view->render('views/order-summary.html');
});

$f3->route('GET|POST /order1', function($f3) {

    //if the form has been submitted--change to post
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        //move data from post array to session array
        $_SESSION['food'] = $_POST['food'];
        $_SESSION['meal'] = $_POST['meal'];

    //redirect to summary page
    $f3->reroute('order2');
    }

    //add meals to F3 hive
    $f3->set('meals', getMeals());


    $view = new Template();
    echo $view->render('views/order-form1.html');
});

$f3->route('GET|POST /order2', function($f3){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_SESSION['conds']=implode(", ", $_POST['conds']);
        $f3->reroute('summary');
    }

    $f3->set('conds', getCondiments());
    $view = new Template();
    echo $view->render('views/order-form2.html');
});
//Run fat free
$f3->run();

?>