<?php

$url = $this->objUrl->getCurrent(['action', 'id']);

require_once('_header.php');

?>

<h1>Orders :: View</h1>

<p>
    There was a problem updating this order.
    Please contact the administrator.<br/>
    <a href="<?php echo $url; ?>">Go back to the list of orders.</a>
</p>

<?php require_once('_header.php'); ?>