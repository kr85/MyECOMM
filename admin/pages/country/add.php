<?php

    $objForm = new Form();
    $objValidation = new Validation($objForm);
    $objValidation->expected = ['name'];
    $objValidation->required= ['name'];

    try {
        if ($objValidation->isValid()) {
            if ($objCountry->add($objValidation->post)) {
                $countries = $objCountry->getAll();
                $replace = [];
                $replace['#countryList'] = Plugin::get('admin' . DS . 'country', [
                    'rows' => $countries,
                    'objUrl' => $this->objUrl
                ]);
                echo Helper::json(['error' => false, 'replace' => $replace]);
            } else {
                $objValidation->addToErrors('name', 'Record could not be added.');
                throw new Exception('Record could not be added.');
            }
        } else {
            throw new Exception('Invalid entry.');
        }
    } catch (Exception $e) {
        echo Helper::json([
            'error' => true,
            'validation' => $objValidation->errorMessages
        ]);
    }