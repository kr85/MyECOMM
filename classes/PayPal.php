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

    /**
     * Instant Payment Notification
     */
    public function ipn()
    {
        if ($this->validateIpn())
        {
            Helper::addToErrorsLog('Validate_IPN_true', null);

            $this->sendCurl();

            if (strcmp($this->ipnResult, "VERIFIED") == 0)
            {
                Helper::addToErrorsLog('IPN_result_verified', null);

                $objOrder = new Order();

                // Update order status
                if (!empty($this->ipnData))
                {
                    Helper::addToErrorsLog('IPN_data_not_empty', null);

                    $approved = $objOrder->approve(
                        $this->ipnData,
                        $this->ipnResult
                    );

                    if (!$approved)
                    {
                        Helper::addToErrorsLog('Order_is_not_approved', null);
                        return false;
                    }

                    Helper::addToErrorsLog('Order_approved', null);
                    return true;
                }

                Helper::addToErrorsLog('IPN_data_is_empty', null);
                return false;
            }

            Helper::addToErrorsLog('IPN_result_not_VERIFIED', null);
            return false;
        }

        Helper::addToErrorsLog('Validate_IPN_failed', null);
        return false;
    }

    /**
     * Validate the IPN
     *
     * @return bool
     */
    private function validateIpn()
    {
        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        // Check if post has been received back from PayPal
        if (!preg_match('/paypal\.com$/', $hostname))
        {
            Helper::addToErrorsLog('Post_not_received_from_PayPal', null);
            return false;
        }

        // Store all posted parameters
        $objForm = new Form();
        $this->ipnData = $objForm->getPostArray();

        // Check if the email of the business and the received email
        // from IPN are the same
        if (!empty($this->ipnData) &&
            array_key_exists('receiver_email', $this->ipnData) &&
            strtolower($this->ipnData['receiver_email'] !=
                strtolower($this->business)
            )
        )
        {
            Helper::addToErrorsLog('In_validateIpn_receiver_email_different', null);
            return false;
        }

        Helper::addToErrorsLog('IPN_validated', null);
        return true;
    }

    /**
     * Send a curl request
     */
    private function sendCurl()
    {
        Helper::addToErrorsLog('In_send_curl', null);

        $response = $this->getReturnParameters();

        Helper::addToErrorsLog(null, $response);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $response);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-www-form-urlencoded",
            "Content-Length: " , strlen($response)
        ]);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        Helper::addToErrorsLog(null, $curl);

        $this->ipnResult = curl_exec($curl);

        Helper::addToErrorsLog(null, $this->ipnResult);

        if (empty($this->ipnResult))
        {
            Helper::addToErrorsLog('IPN_result_after_curl_empty', null);
        }

        curl_close($curl);
    }

    /**
     * Get all parameters from IPN post
     *
     * @return string
     */
    private function getReturnParameters()
    {
        $out = ['cmd=_notify-validate'];

        if (!empty($this->ipnData))
        {
            foreach ($this->ipnData as $key => $value)
            {
                $value = function_exists('get_magic_quotes_gpc') ?
                    urlencode(stripslashes($value)) :
                    urlencode($value);

                $out[] = "{$key}={$value}";
            }
        }
        else
        {
            Helper::addToErrorsLog('IPN_data_empty_in_getParameters', null);
        }

        Helper::addToErrorsLog('Get_return_param_success', null);
        Helper::addToErrorsLog(null, $out);
        return implode("&", $out);
    }
}