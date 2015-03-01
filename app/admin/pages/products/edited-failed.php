<?php

$url = $this->objUrl->getCurrent(['action', 'id']);

require_once('_header.php');

?>

<h1>Products :: Edit</h1>

<p>
    There was a problem updating this product.
    Please contact the administrator.<br/>
    <a href="<?php echo $url; ?>">Go back to the list of products.</a>
</p>

<?php require_once('_header.php'); ?>