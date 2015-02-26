<?php namespace MyECOMM;

/**
 * Class Business
 */
class Business extends Application {

    /**
     * @var string The name of the database table
     */
    protected $table = 'business';

    /**
     * Business id
     */
    const BUSINESS_ID = 1;

    /**
     * Get tax rate
     *
     * @return mixed
     */
    public function getTaxRate() {
        $business = $this->getOne(self::BUSINESS_ID);
        return $business['tax_rate'];
    }
}