<?php

/**
 * Class Basket
 */
class Basket
{
    /**
     * Get active button for basket
     *
     * @param $sessionId
     * @return string
     */
    public static function activeButton($sessionId)
    {
        if (isset($_SESSION['basket'][$sessionId]))
        {
            $id = 0;
            $label = "Remove from basket";
        }
        else
        {
            $id = 1;
            $label = "Add to basket";
        }

        $out = "<a href=\"#\" class=\"add_to_basket";
        $out .= $id == 0 ? " red" : null;
        $out .= "\" rel=\"";
        $out .= $sessionId."_".$id;
        $out .= "\">{$label}</a>";

        return $out;
    }
}