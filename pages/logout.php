<?php

use MyECOMM\Login;

// Log Out and restrict access
Login::logout(Login::$loginFront);
Login::restrictFront($this->objUrl);