<?php

    if ($objShipping->removePostCode($code['id'])) {
        $postCodes = $objShipping->getPostCodes($zone['id']);
        $replace = [];
        $replace['#postCodeList'] = Plugin::get('admin' . DS . 'post-code', [
            'rows' => $postCodes,
            'objUrl' => $this->objUrl
        ]);
        echo Helper::json(['error' => false, 'replace' => $replace]);
    } else {
        throw new Exception('Record could not be removed.');
    }