<?php

$url = $this->objUrl->getCurrent(['action', 'id']);

require_once('_header.php');

?>

<h1>Sections :: Add</h1>

<p>
    The new section has been added successfully.<br/>
    <a href="<?php echo $url; ?>"> Go back to the list of sections.</a>
</p>

<?php require_once('_header.php'); ?>