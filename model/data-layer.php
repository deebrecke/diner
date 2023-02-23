<?php

class DataLayer
{
    //functions and classes have lined up curly braces
    static function getMeals()
    {
        return array("breakfast", "lunch", "dinner", "dessert");
    }

    static function getCondiments()
    {
        return array("none","ketchup", "mustard", "ranch", "syrup", "wasabi", "ginger");
    }
}


//close php tag not required for pages that are all php and no html
//whitespace after php close tag can return a header already sent error