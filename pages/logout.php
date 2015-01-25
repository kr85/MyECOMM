<?php

// Log Out and restrict access
Login::logout(Login::$loginFront);
Login::restrictFront();