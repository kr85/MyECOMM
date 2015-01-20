<?php

/**
 * Class Basket
 */
class Basket
{
    public $instanceCatalog;
    public $emptyBasket;
    public $taxRate;
    public $numberOfItems;
    public $subTotal;
    public $tax;
    public $total;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Instantiate catalog class
        $this->instanceCatalog = new Catalog();
        $this->emptyBasket = empty($_SESSION['basket']) ? true : false;

        // Instantiate business class
        $objBusiness = new Business();
        $this->taxRate = $objBusiness->getTaxRate();

        $this->noItems();
        $this->subTotal();
        $this->tax();
        $this->total();
    }

    /**
     * Get the number of items
     */
    public function noItems()
    {
        $value = 0;

        if (!$this->emptyBasket)
        {
            foreach($_SESSION['basket'] as $key => $basket)
            {
                $value += $basket['quantity'];
            }
        }

        $this->numberOfItems = $value;
    }

    /**
     * Get the subtotal
     */
    public function subTotal()
    {
        $value = 0;

        if (!$this->emptyBasket)
        {
            foreach($_SESSION['basket'] as $key => $basket)
            {
                $product = $this->instanceCatalog->getProduct($key);
                $value += ($basket['quantity'] * $product['price']);
            }
        }

        $this->subTotal = round($value, 2);
    }

    /**
     * Get the tax
     */
    public function tax()
    {
        $value = 0;

        if (!$this->emptyBasket)
        {
            $value = ($this->taxRate * ($this->subTotal / 100));
        }

        $this->tax = round($value, 2);
    }

    /**
     * Get the total
     */
    public function total()
    {
        $this->total = round(($this->subTotal + $this->tax), 2);
    }

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

        $out = "<a href=\"\" class=\"add_to_basket";
        $out .= $id == 0 ? " red" : null;
        $out .= "\" rel=\"";
        $out .= $sessionId."_".$id;
        $out .= "\">{$label}</a>";

        return $out;
    }
}