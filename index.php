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
require_once ('model/data-layer.php');
require_once('model/validate.php');
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



//Define an order1 route (328/diner/order1)
$f3->route('GET|POST /order1', function($f3) {

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //create order object
        $newOrder = new Order();

        //Move food from POST array to SESSION array
        $food = trim($_POST['food']);
        if (validFood($food)) {
            //set the food in the object
            $newOrder->setFood($food);
        }
        else {
            $f3->set('errors["food"]',
                'Food must have at least 2 chars');
        }

        //Validate the meal
        $meal = $_POST['meal'];
        if (validMeal($meal)) {
            $newOrder->setMeal($meal);
        }
        else {
            $f3->set('errors["meal"]',
                'Meal is invalid');
        }



        //Redirect to summary page
        //if there are no errors
        if (empty($f3->get('errors'))) {
            //add order object to session
            $_SESSION['newOrder'] = $newOrder;
            $f3->reroute('order2');
        }
    }

    //Add meals to F3 hive
    $f3->set('meals', getMeals());

    //Instantiate a view
    $view = new Template();
    echo $view->render('views/order-form1.html');

});

//Define an order2 route (328/diner/order2)
$f3->route('GET|POST /order2', function($f3) {

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Move data from POST array to SESSION array
        //$_SESSION['conds'] = implode(", ",$_POST['conds']);

        $condString = implode(", ", $_POST['conds']);
        $_SESSION['newOrder']->setCondiments($condString);

        //Redirect to summary page
        $f3->reroute('summary');
    }

    //Add condiments to the hive
    $f3->set('condiments', getCondiments());

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/order-form2.html");

});

$f3->route('GET /summary', function(){
    //write to database

    //instantiate a view
    $view = new Template();
    echo $view->render('views/order-summary.html');

    session_destroy();
});


//Run fat free
$f3->run();

