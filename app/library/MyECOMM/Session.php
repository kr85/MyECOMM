<?php namespace MyECOMM;

/**
 * Class Session
 */
class Session {

    /**
     * Set an item
     *
     * @param $id
     * @param int $quantity
     */
    public static function setItem($id, $quantity = 1) {
        $_SESSION['basket'][$id]['quantity'] = $quantity;
    }

    /**
     * Remove an item
     *
     * @param $id
     * @param null $quantity
     */
    public static function removeItem($id, $quantity = null) {
        if ($quantity != null && $quantity < $_SESSION['basket'][$id]['quantity']) {
            $_SESSION['basket'][$id]['quantity'] = ($_SESSION['basket'][$id]['quantity'] - $quantity);
        } else {
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
    public static function getSession($name = null) {
        if (!empty($name)) {
            return isset($_SESSION[$name]) ?
                $_SESSION[$name] :
                null;
        }
        return null;
    }

    /**
     * Set the session
     *
     * @param null $name
     * @param null $value
     */
    public static function setSession($name = null, $value = null) {
        if (!empty($name) && !empty($value)) {
            $_SESSION[$name] = $value;
        }
    }

    /**
     * Set recently viewed products for the session
     *
     * @param null $id
     * @param null $value
     */
    public static function setRecentlyViewed($id = null, $value = null) {
        $_SESSION['recentlyViewed'][$id] = $value;
    }

    /**
     * Clear the session
     *
     * @param null $id
     */
    public static function clear($id = null) {
        if (!empty($id)) {
            if (isset($_SESSION[$id])) {
                $_SESSION[$id] = null;
                unset($_SESSION[$id]);
            }
        } else {
            session_destroy();
        }
    }
}