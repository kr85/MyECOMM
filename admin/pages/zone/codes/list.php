<?php

    $postCodes = $objShipping->getPostCodes($zone['id']);

    require_once('_header.php');

?>

<h1>Post Codes for : <?php echo $zone['name']; ?></h1>

<form method="post" class="ajax" data-action="<?php
    echo $this->objUrl->getCurrent('call', false, ['call', 'add'])
?>">
    <table class="tbl_insert">
        <thead>
            <tr>
                <th>
                    <label for="post_code" class="valid_post_code">
                        Post Code: *
                    </label>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input
                        type="text"
                        name="post_code"
                        id="post_code"
                        class="fld fld_small"
                    />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="btn_add" class="sbm sbm_blue fl_l"> <input
                            type="submit" id="btn_add" class="btn" value="Add"/>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<div class="dev br_td">&nbsp;</div>

<div id="postCodeList">
    <?php
        echo Plugin::get('admin' . DS . 'post-code', [
            'rows' => $postCodes,
            'objUrl' => $this->objUrl
        ]);
    ?>
</div>

<?php require_once('_footer.php'); ?>