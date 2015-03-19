<?php namespace MyECOMM;

/**
 * Class Basket
 */
class Basket {

    /**
     * @var Catalog object instance
     */
    private $objCatalog;

    /**
     * @var bool Empty basket variable
     */
    public $emptyBasket;

    /**
     * @var int Tax rate variable
     */
    public $taxRate;

    /**
     * @var int Number of items variable
     */
    public $numberOfItems;

    /**
     * @var double Subtotal amount variable
     */
    public $subTotal;

    /**
     * @var double Tax variable
     */
    private $tax;

    /**
     * @var double Tax amount of items in cart
     */
    public $cartTax;

    /**
     * @var double Total amount variable
     */
    private $total;

    /**
     * @var double Total amount of items in cart
     */
    public $cartTotal;

    /**
     * @var double The total weight of all products in the basket
     */
    public $weight;

    /**
     * @var double List with the products' weight
     */
    private $weightList;

    /**
     * @var The final shipping type
     */
    public $finalShippingType;

    /**
     * @var double The final shipping cost
     */
    public $finalShippingCost;

    /**
     * @var double The final subtotal amount
     */
    public $finalSubtotal;

    /**
     * @var double The final tax amount
     */
    public $finalTax;

    /**
     * @var double The final total amount
     */
    public $finalTotal;

    /**
     * @var User client
     */
    private $user;

    /**
     * @var List of cart products info
     */
    public $productsInfo;

    /**
     * Constructor
     *
     * @param null $user
     */
    public function __construct($user = null) {
        // Check if a user was passed
        if (!empty($user)) {
            $this->user = $user;
        }
        // Instantiate catalog class
        $this->objCatalog = new Catalog();
        $this->emptyBasket = empty($_SESSION['basket']) ? true : false;

        /*
         * Use in other cases of tax rate
         *
        if (!empty($this->user) &&
            ($this->user['country'] == COUNTRY_LOCAL || INTERNATIONAL_VAT)) {
            // Instantiate business class and get the tax rate
            $objBusiness = new Business();
            $this->taxRate = $objBusiness->getTaxRate();
        } else {
            $this->taxRate = 0;
        }
        */

        // Instantiate business class and get the tax rate
        $objBusiness = new Business();
        $this->taxRate = $objBusiness->getTaxRate();

        // Call helper functions
        $this->noItems();
        $this->subTotal();
        $this->tax();
        $this->total();
        $this->productsInfo();
        $this->process();
    }

    /**
     * Get the number of items
     */
    private function noItems() {
        $value = 0;
        if (!$this->emptyBasket) {
            foreach ($_SESSION['basket'] as $key => $basket) {
                $value += $basket['quantity'];
            }
        }
        $this->numberOfItems = $value;
    }

    /**
     * Get the subtotal
     */
    private function subTotal() {
        $value = 0;
        if (!$this->emptyBasket) {
            foreach ($_SESSION['basket'] as $key => $basket) {
                $product = $this->objCatalog->getProduct($key);
                $value += ($basket['quantity'] * $product['price']);
                $this->weightList[] = ($basket['quantity'] * $product['weight']);
            }
        }
        if (!is_array($this->weightList)) {
            $this->weightList = Helper::makeArray($this->weightList);
        }
        $this->weight = array_sum($this->weightList);
        $this->subTotal = round($value, 2);
    }

    /**
     * Get the info of the products in the basket
     */
    private function productsInfo() {
        if (!$this->emptyBasket) {
            foreach ($_SESSION['basket'] as $key => $basket) {
                $product = $this->objCatalog->getProduct($key);
                $product['quantity'] = $basket['quantity'];
                $this->productsInfo[] = $product;
            }
        }
    }

    /**
     * Get the tax
     */
    private function tax() {
        $value = 0;
        if (!$this->emptyBasket) {
            $value = ($this->taxRate * ($this->subTotal / 100));
        }
        $this->tax = round($value, 2);
    }

    /**
     * Get the total
     */
    private function total() {
        $this->total = round(($this->subTotal + $this->tax), 2);
    }

    /**
     * Get active button for basket
     *
     * @param $sessionId
     * @return string
     */
    public static function activeButton($sessionId) {
        if (isset($_SESSION['basket'][$sessionId])) {
            $id = 0;
            $label = "Remove from Cart";
        } else {
            $id = 1;
            $label = "Add to Cart";
        }
        $out = "<a href=\"\" class=\"add_to_basket";
        $out .= ($id == 0) ? " red" : null;
        $out .= "\" rel=\"";
        $out .= $sessionId . "_" . $id;
        $out .= "\">{$label}</a>";
        return $out;
    }

    /**
     * Add the add/remove to/from cart button
     *
     * @param $sessionId
     * @return string
     */
    public static function addRemoveCartButton($sessionId) {
        $style = null;
        if (isset($_SESSION['basket'][$sessionId])) {
            $id = 0;
            $label = "Remove from Cart";
            $style = 'background: #E30000; color: #ffffff; border: 1px solid #950000';
        } else {
            $id = 1;
            $label = "Add to Cart";
        }
        $out = '<button class="add_to_basket button btn-cart"';
        $out .= ' rel="'.$sessionId.'_'.$id.'"';
        $out .= ' id="'.$sessionId.'">';
        $out .= '<span><span style="'.$style.'">';
        $out .= $label;
        $out .= '</span></span>';
        $out .= '</button>';
        return $out;
    }

    /**
     * Calculate the total of an item by price and quantity
     *
     * @param null $price
     * @param null $quantity
     * @return float
     */
    public function itemTotal($price = null, $quantity = null) {
        if (!empty($price) && !empty($quantity)) {
            return round(($price * $quantity), 2);
        }
        return false;
    }

    /**
     * Get the remove item button for the basket
     *
     * @param null $id
     * @return string
     */
    public static function removeButton($id = null) {
        if (!empty($id)) {
            if (isset($_SESSION['basket'][$id])) {
                $out = "<a href=\"#\" class=\"remove_basket btn-remove-2";
                $out .= "\" rel=\"{$id}\" title=\"Remove Product\">Remove</a>";
                return $out;
            }
        }
        return false;
    }

    /**
     * Get the remove item button for the wishlist
     *
     * @param null $id
     * @return bool|string
     */
    public static function removeButtonWishlist($id = null) {
        if (!empty($id)) {
            $out = "<a href=\"#\" class=\"remove_wishlist btn-remove-2";
            $out .= "\" rel=\"{$id}\" title=\"Remove Product\">Remove</a>";
            return $out;
        }
        return false;
    }

    /**
     * Add product to client's wishlist
     *
     * @param null $productId
     * @return bool|string
     */
    public static function addButtonWishlist($productId = null) {
        if (!empty($productId)) {
            $out  = '<a href="#" class="add-to-wishlist" rel="';
            $out .= $productId;
            $out .= '" title="Add Product">Add to Wishlist</a>';
            return $out;
        }
        return false;
    }

    /**
     * Get the remove item button for the small cart
     *
     * @param null $id
     * @return bool|string
     */
    public static function removeButtonSmallCart($id = null) {
        if (!empty($id)) {
            if (isset($_SESSION['basket'][$id])) {
                $out = "<a href=\"#\" class=\"btn-remove remove_basket";
                $out .= "\" rel=\"{$id}\" title=\"Remove Item\">Remove Item</a>";
                return $out;
            }
        }
        return false;
    }

    /**
     * Get the quantity of an item
     *
     * @param null $id
     * @return null
     */
    public static function getItemQty($id = null) {
        return (isset($_SESSION['basket'][$id]['quantity'])) ?
            $_SESSION['basket'][$id]['quantity'] :
            null;
    }

    /**
     * Add shipping to the basket/session
     *
     * @param null $shipping
     * @return bool
     */
    public function addShipping($shipping = null) {
        // Check if shipping passed
        if (!empty($shipping)) {
            Session::setSession('shipping_id', $shipping['id']);
            Session::setSession('shipping_cost', $shipping['cost']);
            Session::setSession('shipping_type', $shipping['name']);
            $this->process();
            return true;
        }
        return false;
    }

    /**
     * Clear the shipping
     */
    public function clearShipping() {
        // Clear the sessions
        Session::clear('id');
        Session::clear('shipping_cost');
        Session::clear('shipping_type');
        // Clear the parameters
        $this->finalShippingType = null;
        $this->finalShippingCost = null;
        $this->finalSubtotal = null;
        $this->finalTax = null;
        $this->finalTotal = null;
    }

    /**
     * Process helper
     */
    private function process() {
        $this->finalShippingType = Session::getSession('shipping_type');
        $this->finalShippingCost = Session::getSession('shipping_cost');
        $this->cartTax = $this->tax;
        $this->cartTotal = round($this->total, 2);
        $this->finalSubtotal = round(($this->subTotal + $this->finalShippingCost), 2);
        $this->finalTax = round(($this->taxRate * ($this->finalSubtotal / 100)), 2);
        $this->finalTotal = round(($this->finalSubtotal + $this->finalTax), 2);
    }
}