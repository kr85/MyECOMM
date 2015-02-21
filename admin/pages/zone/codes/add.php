<?php

    $objForm = new Form();
    $objValidation = new Validation($objForm);
    $objValidation->expected = ['post_code'];
    $objValidation->required = ['post_code'];

    try {
        if ($objValidation->isValid()) {
            $postCode = strtoupper(
                Helper::alphaNumericalOnly($objValidation->post['post_code'])
            );
            if ($objShipping->isDuplicatePostCode($postCode)) {
                $objValidation->addToErrors('post_code', 'Duplicate post code.');
                throw new Exception('Duplicate post code.');
            }
            $params = [
                'country_code' => $postCode,
                'zone' => $zone['id']
            ];
            if ($objShipping->addPostCode($params)) {
                $postCodes = $objShipping->getPostCodes($zone['id']);
                $replace = [];
                $replace['#postCodeList'] = Plugin::get('admin' . DS . 'post-code', [
                    'rows' => $postCodes,
                    'objUrl' => $this->objUrl
                ]);
                echo Helper::json(['error' => false, 'replace' => $replace]);
            } else {
                $objValidation->addToErrors('post_code', 'Record could not be added.');
                throw new Exception('Record could not be added.');
            }
        } else {
            $objValidation->addToErrors('post_code', 'Please provide a post code.');
            throw new Exception('Invalid entry.');
        }
    } catch (Exception $e) {
        echo Helper::json([
            'error' => true,
            'validation' => $objValidation->errorMessages
        ]);
    }