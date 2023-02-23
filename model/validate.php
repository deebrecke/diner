<?php

class Validate
{
    //Return true if the food has at least
    //two characters
    static function validFood($food)
    {
        return strlen($food) > 2;
    }

//Make sure user's meal is valid
    static function validMeal($meal)
    {
        return in_array($meal, DataLayer::getMeals());
    }

}

