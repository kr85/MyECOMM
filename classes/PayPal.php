<?php

/**
 * Class PayPal
 */
class PayPal
{
    // Environment
    private $environment = 'sandbox';

    // Urls
    private $urlProduction = 'https://www.paypal.com/cgi-bin/webscr';
    private $urlSandbox = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    // Standard url
    private $url;

    // Transaction type:
    // xclick = Buy Now buttons
    // cart = basket
    private $cmd;

    // List of all products
    private $products = [];

    // List of all fields
    private $fields = [];

    // PayPal id
    private $business = 'seller-myecomm@gmail.com';

    // Page style
    private $pageStyle = null;

    // Return url
    private $returnUrl;

    // Cancel payment url
    private $cancelPaymentUrl;

    // Notify url (IPN)
    private $notifyUrl;

    // Currency code
    private $currencyCode = 'USD';

    // Tax / Vat amount for cart
    public $taxCart = 0;

    // Tax / Vat amount for xclick
    public $tax = 0;

    // Pre-populate checkout
    public $populateCheckout = [];

    // Data received from PayPal
    private $ipnData = [];

    // Path to the log file for the ipn response
    private $logFilePath = null;

    // Result of sending data back to PayPal after ipn
    private $ipnResult;

    /**
     * Constructor
     *
     * @param string $cmd
     */
    public function __construct($cmd = '_cart')
    {
        $this->url = $this->environment == 'sandbox' ?
            $this->urlSandbox :
            $this->urlProduction;

        $this->cmd = $cmd;

        $this->returnUrl = SITE_URL."/?page=return";
        $this->cancelPaymentUrl = SITE_URL."/?page=cancel";
        $this->notifyUrl = SITE_URL."/?page=ipn";
        $this->logFilePath = ROOT_PATH.DS."log".DS."ipn.log";
    }

    /**
     * Add products to the products list
     *
     * @param $number
     * @param $name
     * @param int $price
     * @param int $quantity
     */
    public function addProduct($number, $name, $price = 0, $quantity = 1)
    {
        switch($this->cmd)
        {
            case '_cart';
                
                $id = count($this->products) + 1;
                $this->products[$id]['item_number_'.$id] = $number;
                $this->products[$id]['item_name_'.$id] = $name;
                $this->products[$id]['amount_'.$id] = $price;
                $this->products[$id]['quantity_'.$id] = $quantity;
                break;

            case '_xclick':

                if (empty($this->products))
                {
                    $this->products[0]['item_number'] = $number;
                    $this->products[0]['item_name'] = $name;
                    $this->products[0]['amount'] = $price;
                    $this->products[0]['quantity'] = $quantity;
                }
                break;
        }
    }

    /**
     * Run the transaction
     *
     * @param null $transactionId
     * @return string
     */
    public function run($transactionId = null)
    {
        if (!empty($transactionId))
        {
            $this->addField('custom', $transactionId);
        }

        return $this->render();
    }

    /**
     * Add each field to the fields list
     *
     * @param null $name
     * @param null $value
     */
    private function addField($name = null, $value = null)
    {
        if (!empty($name) && !empty($value))
        {
            $field = '<input type="hidden" name="'.$name.'" ';
            $field .= 'value="'.$value.'">';

            $this->fields[] = $field;
        }
    }

    /**
     * Render the form
     *
     * @return string
     */
    private function render()
    {
        $out = '<form action="'.$this->url.'" method="POST" id="frm_paypal">';
        $out .= $this->getFields();
        $out .= '<input type="submit" value="Submit" />';
        $out .= '</form>';

        return $out;
    }

    /**
     * Get all fields
     *
     * @return string
     */
    private function getFields()
    {
        $this->processFields();

        if (!empty($this->fields))
        {
            return implode("", $this->fields);
        }
    }

    /**
     * Process all fields
     */
    private function processFields()
    {
        $this->standardFields();

        if (!empty($this->products))
        {
            foreach ($this->products as $product)
            {
                foreach ($product as $key => $value)
                {
                    $this->addField($key, $value);
                }
            }
        }

        $this->prePopulate();
    }

    /**
     * Pre-populate PayPal checkout form
     */
    private function prePopulate()
    {
        if (!empty($this->populateCheckout))
        {
            foreach ($this->populateCheckout as $key => $value)
            {
                $this->addField($key, $value);
            }
        }

    }

    /**
     * Add all required fields
     */
    private function standardFields()
    {
        $this->addField('cmd', $this->cmd);
        $this->addField('business', $this->business);

        if (!empty($this->pageStyle))
        {
            $this->addField('page_style', $this->pageStyle);
        }

        $this->addField('return', $this->returnUrl);
        $this->addField('notify_url', $this->notifyUrl);
        $this->addField('cancel_payment', $this->cancelPaymentUrl);
        $this->addField('currency_code', $this->currencyCode);
        $this->addField('rm', 2);

        switch($this->cmd)
        {
            case '_cart':

                if ($this->taxCart != 0)
                {
                    $this->addField('tax_cart', $this->taxCart);
                }

                $this->addField('upload', 1);
                break;

            case '_xclick':

                if ($this->tax != 0)
                {
                    $this->addField('tax', $this->tax);
                }

                break;
        }
    }
}