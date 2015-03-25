<?php

use MyECOMM\Plugin;

$postCodes = $objShipping->getPostCodes($zone['id']);

require_once('_header.php');

?>

<div class="listing zone-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="dashboard">
                <a href="/panel/zone" title="Go to Local Zones">Local Zones</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Post Codes for <?php echo $zone['name']; ?>
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Post Codes for <?php echo $zone['name']; ?></h1>
    </div>
    <div class="post-codes-add">
        <form method="post" class="ajax" data-action="<?php
            echo $this->objUrl->getCurrent('call', false, ['call', 'add'])
        ?>">
            <table>
                <tr>
                    <td>
                        <label for="post_code">
                            Post Code: <em>*</em>
                        </label>
                    </td>
                    <td>
                        <input
                            type="text"
                            name="post_code"
                            id="post_code"
                            class="fld fld_small"
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
                    <td colspan="3" class="valid_post_code"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="clearfix"></div>
<div id="postCodeList">
    <?php
        echo Plugin::get('admin'.DS.'post-code', [
            'rows' => $postCodes,
            'objUrl' => $this->objUrl
        ]);
    ?>
</div>

<?php require_once('_footer.php'); ?>