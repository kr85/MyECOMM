<?php

use MyECOMM\Login;

// Log out and restrict access
Login::logout(Login::$loginAdmin);
Login::restrictAdmin();