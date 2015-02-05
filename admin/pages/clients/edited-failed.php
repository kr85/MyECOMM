<?php
    $url = $this->objUrl->getCurrent(['action', 'id']);

    require_once('_header.php');
?>

    <h1>Clients :: Edit</h1>
    <p>
        There was a problem updating this client.
        Please contact the administrator.<br/>
        <a href="<?php echo $url; ?>">
            Go back to the list of clients.
        </a>
    </p>

<?php require_once('_header.php'); ?>