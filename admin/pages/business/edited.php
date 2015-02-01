<?php
    $url = $this->objUrl->getCurrent(['action', 'id']);

    require_once('_header.php');
?>

    <h1>Business :: Edit</h1>
    <p>
        The business information has been updated successfully.<br/>
        <a href="<?php echo $url; ?>">
            Go back to the business page.
        </a>
    </p>

<?php require_once('_header.php'); ?>