<?php

    $objForm = new Form();
    $objValidation = new Validation($objForm);
    $objValidation->expected = ['weight', 'cost'];
    $objValidation->required = ['weight', 'cost'];

    try {
        if ($objValidation->isValid()) {
            if ($objShipping->isDuplicateInternational($id, $zid, $objValidation->post['weight'])) {
                $objValidation->addToErrors('weight', 'Duplicate weight.');
                throw new Exception('Duplicate weight.');
            }

            $objValidation->post['type'] = $id;
            $objValidation->post['country'] = $zid;

            if ($objShipping->addShipping($objValidation->post)) {
                $shipping = $objShipping->getShippingByTypeCountry($id, $zid);
                $replace = [];
                $replace['#shippingList'] = Plugin::get('admin' . DS . 'shipping-cost', [
                    'rows' => $shipping,
                    'objUrl' => $this->objUrl
                ]);
                echo Helper::json(['error' => false, 'replace' => $replace]);
            } else {
                $objValidation->addToErrors('weight', 'Record could not be added.');
                throw new Exception('Record could not be added.');
            }
        } else {
            throw new Exception('Invalid request.');
        }
    } catch (Exception $e) {
        echo Helper::json([
            'error' => true,
            'validation' => $objValidation->errorMessages
        ]);
    }