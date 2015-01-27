<?php
    $url = '/admin' . Url::getCurrentUrl(['action', 'id']);

    require_once('templates/_header.php');
?>

    <h1>Orders :: View</h1>
    <p>
        The order has been updated successfully.<br/>
        <a href="<?php echo $url ?>">
            Go back to the list of orders.
        </a>
    </p>

<?php require_once('templates/_header.php'); ?>