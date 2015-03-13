<?php namespace MyECOMM;

/**
 * Class Validation
 */
class Validation {

    /**
     * @var Form|null Form object instance
     */
    private $objForm;

    /**
     * @var array List of validation errors
     */
    private $errors = [];

    /**
     * @var array List of validation successes
     */
    private $success = [];

    /**
     * @var array List of error messages
     */
    public $errorMessages = [];

    /**
     * @var array List of success messages
     */
    public $successMessages = [];

    /**
     * @var array List of validation error messages
     */
    public $messages = [
        'first_name'         => 'Please provide your first name.',
        'last_name'          => 'Please provide your last name.',
        'address_1'          => 'Please provide the first line of your address.',
        'address_2'          => 'Please provide the second line of your address.',
        'city'               => 'Please provide the name of your city.',
        'state'              => 'Please provide the name of your state.',
        'zip_code'           => 'Please provide your ZIP code.',
        'country'            => 'Please select your country.',

        'shipping_address_1' => 'Please provide the first line of the address.',
        'shipping_address_2' => 'Please provide the second line of the address.',
        'shipping_city'      => 'Please provide the name of the city.',
        'shipping_state'     => 'Please provide the name of the state.',
        'shipping_zip_code'  => 'Please provide the ZIP code.',
        'shipping_country'   => 'Please select the country.',

        'email'              => 'Please provide your valid email address.',
        'email_duplicate'    => 'This email address already exists.',
        'login'              => 'Email address and/or password are incorrect.',
        'password'           => 'Please choose your password.',
        'confirm_password'   => 'Please confirm your password.',
        'password_mismatch'  => 'Passwords do not match.',
        'category'           => 'Please select a category.',
        'name'               => 'Please provide a name.',
        'name_duplicate'     => 'This name already exist.',
        'description'        => 'Please provide a description.',
        'price'              => 'Please provide a price.',
        'address'            => 'Please provide an address.',
        'telephone'          => 'Please provide a phone number.',
        'website'            => 'Please provide a website.',
        'tax_rate'           => 'Please provide a tax rate.',

        'identity'           => 'Please provide the identity.',
        'duplicate_identity' => 'This identity already exists.',
        'meta_title'         => 'Please provide the meta title.',
        'meta_description'   => 'Please provide the meta description.',
        'meta_keywords'      => 'Please provide the meta keywords.',

        'weight'             => 'Please provide the weight.',
        'cost'               => 'Please provide the cost.',

        'order_id'           => 'Please provide the order id.',
        'order_not_found'    => 'The order was not found. Please try again.',
        'comment'            => 'Please write a comment.',
        'email_not_sent'     => 'There was a problem sending the email. Please try again.',
        'email_sent'         => 'Your comment was successfully sent.'
    ];

    /**
     * @var array List of expected fields
     */
    public $expected = [];

    /**
     * @var array List of required fields
     */
    public $required = [];

    /**
     * @var array List of special validation
     */
    public $special = [];

    /**
     * @var array List of post parameters
     */
    public $post = [];

    /**
     * @var array List of fields to be removed from post
     */
    public $postRemove = [];

    /**
     * @var array List of fields to be specifically formatted
     */
    public $postFormat = [];

    /**
     * Constructor
     *
     * @param null $objForm
     */
    public function __construct($objForm = null) {
        $this->objForm = (is_object($objForm)) ? $objForm : new Form();
    }

    /**
     * Process form validation
     */
    public function process() {
        if ($this->objForm->isPost()) {
            $this->post = !empty($this->post) ?
                $this->post :
                $this->objForm->getPostArray($this->expected);
            if (!empty($this->post)) {
                foreach ($this->post as $key => $value) {
                    $this->check($key, $value);
                }
            }
        }
    }

    /**
     * Check validation
     *
     * @param $key
     * @param $value
     */
    public function check($key = null, $value = null) {
        if (!empty($this->special) && array_key_exists($key, $this->special)) {
            $this->checkSpecial($key, $value);
        } else {
            if (in_array($key, $this->required) && Helper::isEmpty($value)) {
                $this->addToErrors($key);
            }
        }
    }

    /**
     * Check special validation cases
     *
     * @param $key
     * @param $value
     */
    public function checkSpecial($key = null, $value = null) {
        switch ($this->special[$key]) {
            case 'email':
                if (!$this->isEmail($value)) {
                    $this->addToErrors($key);
                }
                break;
        }
    }

    /**
     * Add to errors list
     *
     * @param null $key
     * @param null $value
     */
    public function addToErrors($key = null, $value = null) {
        if (!empty($key)) {
            $this->errors[] = $key;
            if (!empty($value)) {
                $this->errorMessages['valid_'.$key] = $this->wrapWarning($value);
            } else if (array_key_exists($key, $this->messages)) {
                $this->errorMessages['valid_'.$key] =
                    $this->wrapWarning($this->messages[$key]);
            }
        }
    }

    /**
     * Add to success messages list
     *
     * @param null $key
     * @param null $value
     */
    public function addToSuccess($key = null, $value = null) {
        if (!empty($key)) {
            $this->success[] = $key;
            if (!empty($value)) {
                $this->successMessages['valid_'.$key] = $this->wrapMessage($value);
            } else if (array_key_exists($key, $this->messages)) {
                $this->successMessages['valid_'.$key] =
                    $this->wrapMessage($this->messages[$key]);
            }
        }
    }

    /**
     * Check if it is a valid email
     *
     * @param null $email
     * @return bool
     */
    public function isEmail($email = null) {
        if (!empty($email)) {
            $result = filter_var($email, FILTER_VALIDATE_EMAIL);
            return (!$result) ? false : true;
        }
        return false;
    }

    /**
     * Check if fields are valid
     *
     * @param null $array
     * @return bool
     */
    public function isValid($array = null) {
        // Check if something was passed and store it in post array
        if (!empty($array)) {
            $this->post = $array;
        }
        // Process validation
        $this->process();
        if (empty($this->errors) && !empty($this->post)) {
            // Remove all unwanted fields
            if (!empty($this->postRemove)) {
                foreach ($this->postRemove as $value) {
                    unset($this->post[$value]);
                }
            }
            // Format all required fields
            if (!empty($this->postFormat)) {
                foreach ($this->postFormat as $key => $value) {
                    $this->format($key, $value);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Format a field
     *
     * @param $key
     * @param $value
     */
    public function format($key = null, $value = null) {
        switch ($value) {
            case 'password':
                $this->post[$key] = Login::stringToHash($this->post[$key]);
                break;
        }
    }

    /**
     * Get warning if validation errors exist
     *
     * @param $key
     * @return string
     */
    public function validate($key = null) {
        if (!empty($this->errors) && in_array($key, $this->errors)) {
            return $this->wrapWarning($this->messages[$key]);
        } elseif (!empty($this->success) && in_array($key, $this->success)) {
            return $this->wrapMessage($this->messages[$key]);
        }
        return false;
    }



    /**
     * Wrap validation error in html
     *
     * @param null $message
     * @return string
     */
    public function wrapWarning($message = null) {
        if (!empty($message)) {
            return "<div class='error-msg'><span class=\"warn\">{$message}</span></div>";
        }
        return false;
    }

    /**
     * Wrap the success message in html
     *
     * @param null $message
     * @return bool|string
     */
    public function wrapMessage($message = null) {
        if (!empty($message)) {
            return "<div class='success-msg'><span class=\"success\">{$message}</span></div>";
        }
        return false;
    }
}