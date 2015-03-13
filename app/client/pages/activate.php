<?php

use MyECOMM\User;
use MyECOMM\Helper;

$code = $this->objUrl->get('code');

if (!empty($code)) {

    $objUser = new User();
    $user = $objUser->getUserByHash($code);

    if (!empty($user)) {
        if ($user['active'] == 0) {
            if ($objUser->activate($user['id'])) {
                $message  = '<div class="main" style="text-align: center">';
                $message .= '<div class="page-title">';
                $message .= '<h1>Thank you</h1>';
                $message .= '</div>';
                $message .= '<p>Your account has been successfully activated.<br />';
                $message .= 'You can log in and continue your order.</p>';
                $message .= '</div>';
            } else {
                $message  = '<div class="main" style="text-align: center">';
                $message .= '<div class="page-title">';
                $message .= '<h1>Activation was unsuccessful</h1>';
                $message .= '</div>';
                $message .= '<p>There has been a problem activating your account.<br />';
                $message .= 'Please contact the administrator.</p>';
                $message .= '</div>';
            }
        } else {
            $message  = '<div class="main" style="text-align: center">';
            $message .= '<div class="page-title">';
            $message .= '<h1>Account already activated</h1>';
            $message .= '</div>';
            $message .= '<p>This account has already been activated.</p>';
            $message .= '</div>';
        }
    } else {
        Helper::redirect($this->objUrl->href('error'));
    }
    require_once("_header.php");
    echo $message;
    require_once("_footer.php");
} else {
    Helper::redirect($this->objUrl->href('error'));
}