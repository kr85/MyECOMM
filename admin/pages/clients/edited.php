<?php
    $url = '/admin' . Url::getCurrentUrl(['action', 'id']);

    require_once('templates/_header.php');
?>

    <h1>Clients :: Edit</h1>
    <p>
        The client has been updated successfully.<br/>
        <a href="<?php echo $url ?>">
            Go back to the list of clients.
        </a>
    </p>

<?php require_once('templates/_header.php'); ?>