<?php

$url = $this->objUrl->getCurrent(['action', 'id']);

require_once('_header.php');

?>

<h1>Sections :: Edit</h1>

<p>
    The section has been updated successfully.<br/>
    <a href="<?php echo $url; ?>">Go back to the list of sections.</a>
</p>

<?php require_once('_header.php'); ?>