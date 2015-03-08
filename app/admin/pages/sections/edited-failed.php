<?php

$url = $this->objUrl->getCurrent(['action', 'id']);

require_once('_header.php');

?>

<h1>Sections :: Edit</h1>

<p>
    There was a problem updating this section.
    Please contact the administrator.<br/>
    <a href="<?php echo $url; ?>">Go back to the list of sections.</a>
</p>

<?php require_once('_header.php'); ?>