<?php

    $code = $this->objUrl->get('code');

    if (!empty($code)) {

        $objUser = new User();
        $user = $objUser->getUserByHash($code);

        if (!empty($user)) {
            if ($user['active'] == 0) {
                if ($objUser->activate($user['id'])) {
                    $message = "<h1>Thank you</h1>";
                    $message .= "<p>Your account has been successfully activated.<br />";
                    $message .= "You can log in and continue your order.</p>";
                }
                else {
                    $message = "<h1>Activation was unsuccessful</h1>";
                    $message .= "<p>There has been a problem activating your account.<br />";
                    $message .= "Please contact the administrator.</p>";
                }
            }

            else {
                $message = "<h1>Account already activated</h1>";
                $message .= "<p>This account has already been activated.</p>";
            }
        }
        else {
            Helper::redirect($this->objUrl->href('error'));
        }
        require_once("_header.php");
        echo $message;
        require_once("_footer.php");
    }
    else {
        Helper::redirect($this->objUrl->href('error'));
    }