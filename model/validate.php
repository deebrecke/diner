<?php

//Return true if the food has at least
//two characters
function validFood($food)
{
    return strlen($food) > 2;
}

//Make sure user's meal is valid
function validMeal($meal)
{
    return in_array($meal, getMeals());
}
