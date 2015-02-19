<?php
    // Restrict access only to logged in admin users
    Login::restrictAdmin();

    // Instantiate shipping
    $objShipping = new Shipping();

    $id = $this->objUrl->get('id');
    $action = $this->objUrl->get('action');

    try {
        switch ($action) {
            // Cases that need the id parameter
            case 'default':
            case 'active':
            case 'remove':
            case 'update':
            case 'duplicate':
            case 'rates':
            // Check if the id exists
            if (!empty($id)) {
                // Get the shipping type
                $type = $objShipping->getType($id);
                // Check if the type exists
                if (!empty($type)) {
                    switch ($action) {
                        case 'default':
                            require_once('shipping/default.php');
                            break;
                        case 'active':
                            require_once('shipping/active.php');
                            break;
                        case 'remove':
                            require_once('shipping/remove.php');
                            break;
                        case 'update':
                            require_once('shipping/update.php');
                            break;
                        case 'duplicate':
                            require_once('shipping/duplicate.php');
                            break;
                        case 'rates':
                            require_once('shipping/rates.php');
                            break;
                    }
                } else {
                    throw new Exception('Record not found.');
                }
            } else {
                throw new Exception('Missing parameter.');
            }
            break;
            // Cases that do not need the id parameter
            case 'sort':
                require_once('shipping/sort.php');
                break;
            case 'add':
                require_once('shipping/add.php');
                break;
            default:
                require_once('shipping/list.php');
        }
    } catch (Exception $e) {
        echo Helper::json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
    }