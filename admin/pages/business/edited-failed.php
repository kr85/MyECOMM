<?php
    $url = $this->objUrl->getCurrent(['action', 'id']);

    require_once('_header.php');
?>

    <h1>Business :: Edit</h1>
    <p>
        There was a problem updating the business information.
        Please contact the administrator.<br/>
        <a href="<?php echo $url; ?>">
            Go back to the business page.
        </a>
    </p>

<?php require_once('_header.php'); ?>