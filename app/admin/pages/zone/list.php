<?php

use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Plugin;

$objForm = new Form();
$objValidation = new Validation($objForm);

$zones = $objShipping->getZones();

require_once('_header.php'); ?>

<div class="listing zone-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Local Zones
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Local Zones</h1>
    </div>
    <div class="local-zone-add">
        <form method="post" class="ajax" data-action="<?php
            echo $this->objUrl->getCurrent(
                 ['action', 'id'], false, ['action', 'add']
            );
        ?>">
            <table>
                <tr>
                    <td>
                        <label for="name">
                            Zone Name: <em>*</em>
                        </label>
                    </td>
                    <td>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="fld"
                            placeholder="Add a new local zone..."
                            />
                    </td>
                    <td>
                        <button class="button" type="submit">
                                <span>
                                        <span>Add</span>
                                </span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="valid_name"></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="clearfix"></div>
    <form method="post" data-url="<?php
    echo $this->objUrl->getCurrent(
            ['action', 'id'], false, ['action', 'update', 'id']
        ) . '/';
    ?>">
        <div id="zoneList">
            <?php echo Plugin::get('admin'.DS.'zone', [
                'rows' => $zones,
                'objUrl' => $this->objUrl
            ]); ?>
        </div>
    </form>
</div>

<?php require_once('_footer.php'); ?>