<?php

class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function default()
    {
        $view = new Template();
        echo $view->render('views/diner-home.html');
    }

    function order1()
    {
        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //create order object
            $newOrder = new Order();

            //Move food from POST array to SESSION array
            $food = trim($_POST['food']);
            if (Validate::validFood($food)) {
                //set the food in the object
                $newOrder->setFood($food);
            }
            else {
                $this->_f3->set('errors["food"]',
                    'Food must have at least 2 chars');
            }

            //Validate the meal
            $meal = $_POST['meal'];
            if (Validate::validMeal($meal)) {
                $newOrder->setMeal($meal);
            }
            else {
                $this->_f3->set('errors["meal"]',
                    'Meal is invalid');
            }

            //Redirect to summary page
            //if there are no errors
            if (empty($this->_f3->get('errors'))) {
                //add order object to session
                $_SESSION['newOrder'] = $newOrder;
                $this->_f3->reroute('order2');
            }
        }

        //Add meals to F3 hive
        $this->_f3->set('meals', DataLayer::getMeals());

        //Instantiate a view
        $view = new Template();
        echo $view->render('views/order-form1.html');
    }

    function order2()
    {

        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Move data from POST array to SESSION array
            //$_SESSION['conds'] = implode(", ",$_POST['conds']);

            $condString = implode(", ", $_POST['conds']);
            $_SESSION['newOrder']->setCondiments($condString);

            //Redirect to summary page
            $this->_f3->reroute('summary');
        }

        //Add condiments to the hive
        $this->_f3->set('condiments', DataLayer::getCondiments());

        //Instantiate a view
        $view = new Template();
        echo $view->render("views/order-form2.html");
    }

    function summary()
    {
        //TODO: write to database

        //instantiate a view
        $view = new Template();
        echo $view->render('views/order-summary.html');

        session_destroy();
    }

}