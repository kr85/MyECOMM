<?php

/**
 * Class Validation
 */
class Validation
{
    // Form object
    private $objForm;

    // List of validation errors
    private $errors = [];

    // List of validation error messages
    public $message = [
        'first_name' => 'Please provide your first name',
        'last_name'  => 'Please provide your last name',
        'address_1'  => 'Please provide the first line of your address',
        'address_2'  => 'Please provide the second line of your address',
        'city'       => 'Please provide the name of your city',
        'state'      => 'Please provide the name of your state',
        'zip_code'   => 'Please provide your ZIP code',
        'country'    => 'Please provide your country',
        'email'      => 'Please provide your valid email address',
        'login'      => 'User and/or password are incorrect',
        'password'   => 'Please choose your password',
        'confirm_password' => 'Please confirm your password',
        'password_mismatch' => 'Passwords do not match'
    ];

    // List of expected fields
    public $expected = [];

    // List of required fields
    public $required = [];

    // List of special validation
    public $special = [];

    // List of post
    public $post = [];

    // List of fields to be removed from post
    public $postRemove = [];

    // List of fields to be specifically formatted
    public $postFormat = [];

    /**
     * Constructor
     *
     * @param Form $objForm
     */
    public function __construct($objForm)
    {
        $this->objForm = $objForm;
    }

    /**
     * Process form validation
     */
    public function process()
    {
        if ($this->objForm->isPost() && !empty($this->required))
        {
            $this->post = $this->objForm->getPostArray($this->expected);

            if (!empty($this->post))
            {
                foreach($this->post as $key => $value)
                {
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
    public function check($key, $value)
    {
        if (!empty($this->special) && array_key_exists($key, $this->special))
        {
            $this->checkSpecial($key, $value);
        }
        else
        {
            if (in_array($key, $this->required) && empty($value))
            {
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
    public function checkSpecial($key, $value)
    {
        switch($this->special[$key])
        {
            case 'email':
                if (!$this->isEmail($value))
                {
                    $this->addToErrors($key);
                }
                break;
        }
    }

    /**
     * Add to errors list
     *
     * @param $key
     */
    public function addToErrors($key)
    {
        $this->errors[] = $key;
    }

    /**
     * Check if it is a valid email
     *
     * @param null $email
     * @return bool
     */
    public function isEmail($email = null)
    {
        if (!empty($email))
        {
            $result = filter_var($email, FILTER_VALIDATE_EMAIL);

            return !$result ? false : true;
        }

        return false;
    }

    /**
     * Check if fields are valid
     *
     * @return bool
     */
    public function isValid()
    {
        $this->process();

        if (empty($this->errors) && !empty($this->post))
        {
            // Remove all unwanted fields
            if (!empty($this->postRemove))
            {
                foreach($this->postRemove as $value)
                {
                    unset($this->post[$value]);
                }
            }

            // Format all required fields
            if (!empty($this->postFormat))
            {
                foreach($this->postFormat as $key => $value)
                {
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
    public function format($key, $value)
    {
        switch($value)
        {
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
    public function validate($key)
    {
        if (!empty($this->errors) && in_array($key, $this->errors))
        {
            return $this->wrapWarning($this->message[$key]);
        }
    }

    /**
     * Wrap validation error in html
     *
     * @param null $message
     * @return string
     */
    public function wrapWarning($message = null)
    {
        if (!empty($message))
        {
            return "<span class=\"warn\">{$message}</span>";
        }
    }
}