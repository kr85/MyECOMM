<?php namespace MyECOMM;

/**
 * Class PayPal
 */
class PayPal {

    /**
     * @var string Environment
     */
    private $environment = 'sandbox';

    /**
     * @var string PayPal production url
     */
    private $urlProduction = 'https://www.paypal.com/cgi-bin/webscr';

    /**
     * @var string PayPal development url
     */
    private $urlSandbox    = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    /**
     * @var string Standard url
     */
    private $url;

    /**
     * @var string Transaction type:
     * xclick => Buy Now buttons
     * cart => basket
     */
    private $cmd;

    /**
     * @var array List of all products
     */
    private $products = [];

    /**
     * @var array List of all fields
     */
    private $fields = [];

    /**
     * @var null PayPal id
     */
    private $business = null;

    /**
     * @var null Custom page style
     */
    private $pageStyle = null;

    /**
     * @var Return url
     */
    private $returnUrl;

    /**
     * @var string Cancel payment url
     */
    private $cancelPaymentUrl;

    /**
     * @var string Notify url (IPN)
     */
    private $notifyUrl;

    /**
     * @var string Currency code
     */
    private $currencyCode = 'USD';

    /**
     * @var int Tax / Vat amount for cart
     */
    public $taxCart = 0;

    /**
     * @var int Tax / Vat amount for xclick
     */
    public $tax = 0;

    /**
     * @var int Shipping value
     */
    public $shipping = 0;

    /**
     * @var array Pre-populate checkout
     */
    public $populateCheckout = [];

    /**
     * @var array Data received from PayPal
     */
    private $ipnData = [];

    /**
     * @var Result of sending data back to PayPal after ipn
     */
    private $ipnResult;

    /**
     * @var Url|null Url object instance
     */
    public $objUrl;

    /**
     * Constructor
     *
     * @param null $objUrl
     * @param string $cmd
     */
    public function __construct($objUrl = null, $cmd = '_cart') {
        $this->objUrl = is_object($objUrl) ? $objUrl : new Url();
        $this->business = PAYPAL_BUSINESS_ID;
        $this->url = ($this->environment == 'sandbox') ?
            $this->urlSandbox :
            $this->urlProduction;
        $this->cmd = $cmd;
        $this->cancelPaymentUrl = SITE_URL.$this->objUrl->href('cancel');
        $this->notifyUrl = SITE_URL.$this->objUrl->href('ipn');
    }

    /**
     * Add products to the products list
     *
     * @param $number
     * @param $name
     * @param int $price
     * @param int $quantity
     */
    public function addProduct($number, $name, $price = 0, $quantity = 1) {
        switch ($this->cmd) {
            case '_cart';
                $id = count($this->products) + 1;
                $this->products[$id]['item_number_'.$id] = $number;
                $this->products[$id]['item_name_'.$id] = $name;
                $this->products[$id]['amount_'.$id] = $price;
                $this->products[$id]['quantity_'.$id] = $quantity;
                break;
            case '_xclick':
                if (empty($this->products)) {
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
     * @param null $transactionToken
     * @return string
     */
    public function run($transactionToken = null) {
        if (!empty($transactionToken)) {
            $this->returnUrl = SITE_URL.$this->objUrl->href('return', [
                    'token',
                    $transactionToken
                ]);
            $this->addField('custom', $transactionToken);
        }
        return $this->render();
    }

    /**
     * Add each field to the fields list
     *
     * @param null $name
     * @param null $value
     */
    private function addField($name = null, $value = null) {
        if (!empty($name) && !empty($value)) {
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
    private function render() {
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
    private function getFields() {
        $this->processFields();
        if (!empty($this->fields)) {
            return implode("", $this->fields);
        }
        return false;
    }

    /**
     * Process all fields
     */
    private function processFields() {
        $this->standardFields();
        if (!empty($this->products)) {
            foreach ($this->products as $product) {
                foreach ($product as $key => $value) {
                    $this->addField($key, $value);
                }
            }
        }
        $this->prePopulate();
    }

    /**
     * Pre-populate PayPal checkout form
     */
    private function prePopulate() {
        if (!empty($this->populateCheckout)) {
            foreach ($this->populateCheckout as $key => $value) {
                $this->addField($key, $value);
            }
        }
    }

    /**
     * Add all required fields
     */
    private function standardFields() {

        $this->addField('cmd', $this->cmd);
        $this->addField('business', $this->business);

        if (!empty($this->pageStyle)) {
            $this->addField('page_style', $this->pageStyle);
        }

        $this->addField('return', $this->returnUrl);
        $this->addField('notify_url', $this->notifyUrl);
        $this->addField('cancel_payment', $this->cancelPaymentUrl);
        $this->addField('currency_code', $this->currencyCode);
        $this->addField('rm', 2);

        if (!empty($this->shipping)) {
            $this->addField('handling_cart', $this->shipping);
        }

        switch ($this->cmd) {
            case '_cart':
                if ($this->taxCart != 0) {
                    $this->addField('tax_cart', $this->taxCart);
                }
                $this->addField('upload', 1);
                break;
            case '_xclick':
                if ($this->tax != 0) {
                    $this->addField('tax', $this->tax);
                }
                break;
        }
    }

    /**
     * Instant Payment Notification
     */
    public function ipn() {
        if ($this->validateIpn()) {
            $this->sendCurl();
            if (strcmp($this->ipnResult, "VERIFIED") == 0) {
                $objOrder = new Order();
                // Update order status
                if (!empty($this->ipnData)) {
                    $approved = $objOrder->approve(
                        $this->ipnData,
                        $this->ipnResult
                    );
                    if (!$approved) {
                        return false;
                    }
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    /**
     * Validate the IPN
     *
     * @return bool
     */
    private function validateIpn() {
        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        // Check if post has been received back from PayPal
        if (!preg_match('/paypal\.com$/', $hostname)) {
            return false;
        }
        // Store all posted parameters
        $objForm = new Form();
        $this->ipnData = $objForm->getPostArray();
        // Check if the email of the business and the received email
        // from IPN are the same
        if (!empty($this->ipnData) && array_key_exists(
                'receiver_email',
                $this->ipnData
            ) && strtolower(
                $this->ipnData['receiver_email'] != strtolower(
                    $this->business
                )
            )
        ) {
            return false;
        }
        return true;
    }

    /**
     * Send a curl request
     */
    private function sendCurl() {
        $response = $this->getReturnParameters();
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            [
                CURLOPT_URL => $this->url,
                CURLOPT_SSL_VERIFYPEER => 1,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_ENCODING => 'gzip',
                CURLOPT_BINARYTRANSFER => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $response,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_FORBID_REUSE => true,
                CURLOPT_FORBID_REUSE => true,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_HEADER => false,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_VERBOSE => 1,
                CURLINFO_HEADER_OUT => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Content-Length: '.strlen($response),
                    'Connection: close'
                ]
            ]
        );
        $this->ipnResult = curl_exec($curl);
        curl_close($curl);
    }

    /**
     * Get all parameters from IPN post
     *
     * @return string
     */
    private function getReturnParameters() {
        $out = ['cmd=_notify-validate'];
        if (!empty($this->ipnData)) {
            foreach ($this->ipnData as $key => $value) {
                $value = function_exists('get_magic_quotes_gpc') ?
                    urlencode(stripslashes($value)) :
                    urlencode($value);
                $out[] = "{$key}={$value}";
            }
        }
        return implode("&", $out);
    }
}