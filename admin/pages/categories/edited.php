<?php
    $url = $this->objUrl->getCurrent(['action', 'id']);

    require_once('_header.php');
?>

    <h1>Categories :: Edit</h1>
    <p>
        The category has been updated successfully.<br/>
        <a href="<?php echo $url; ?>">
            Go back to the list of categories.
        </a>
    </p>

<?php require_once('_header.php'); ?>