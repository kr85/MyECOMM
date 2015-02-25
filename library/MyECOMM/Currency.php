<?php namespace MyECOMM;

use \Exception;

/**
 * Class Currency
 *
 * @package MyECOMM
 */
class Currency {

    /**
     * @var array List of available currency
     */
    private $list = [
        'GBP' => [
            'symbol' => '£',
            'html' => '&#163;'
        ],
        'USD' => [
            'symbol' => '$',
            'html' => '&#36;'
        ],
        'EUR' => [
            'symbol' => '€',
            'html' => '&#8364;'
        ]
    ];

    /**
     * @var string Default currency
     */
    private $default = 'USD';

    /**
     * @var Currency index
     */
    private $index;

    /**
     * @var Currency code
     */
    public $code;

    /**
     * @var Currency symbol
     */
    public $symbol;

    /**
     * @var Currency html code
     */
    public $html;

    /**
     * Constructor
     */
    public function __construct() {
        $this->process();
    }

    /**
     * Display currency symbol with the value
     *
     * @param null $value
     * @return string
     */
    public function display($value = null) {
        switch ($this->index) {
            case 'GBP':
                return $this->symbol.$value;
                break;
            case 'USD':
                return $this->symbol.$value;
                break;
            case 'EUR':
                return $this->symbol.$value;
                break;
        }
    }

    /**
     * Process
     */
    private function process() {
        $this->getCurrentIndex();
        $this->code = $this->index;
        $this->symbol = $this->list[$this->index]['symbol'];
        $this->html = $this->list[$this->index]['html'];
    }

    /**
     * Get the current index
     */
    private function getCurrentIndex() {
        try {
            $this->index = $this->default;
            if (!$this->codeExist($this->index)) {
                throw new Exception('The currency code could not be found.');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * Check if currency code exists in currency list
     *
     * @param null $code
     * @return bool
     */
    private function codeExist($code = null) {
        return (!empty($code) && array_key_exists($code, $this->list));
    }
}