<?php

/**
 * Class Session
 */
class Session
{
    /**
     * Set an item
     *
     * @param $id
     * @param int $quantity
     */
    public static function setItem($id, $quantity = 1)
    {
        $_SESSION['basket'][$id]['quantity'] = $quantity;
    }

    /**
     * Remove an item
     *
     * @param $id
     * @param null $quantity
     */
    public static function removeItem($id, $quantity = null)
    {
        if ($quantity != null && $quantity < $_SESSION['basket'][$id]['quantity'])
        {
            $_SESSION['basket'][$id]['quantity'] = ($_SESSION['basket'][$id]['quantity'] - $quantity);
        }
        else
        {
            $_SESSION['basket'][$id] = null;
            unset($_SESSION['basket'][$id]);
        }
    }

    /**
     * Get session
     *
     * @param null $name
     * @return null
     */
    public static function getSession($name = null)
    {
        if (!empty($name))
        {
            return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
        }
    }

}