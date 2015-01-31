<?php
    $url = $this->objUrl->getCurrent(['action', 'id']);

    require_once('_header.php');
?>

    <h1>Products :: Edit</h1>
    <p>
        The product has been updated successfully but without changing the image.<br/>
        <a href="<?php echo $url ?>">
            Go back to the list of products.
        </a>
    </p>

<?php require_once('_header.php'); ?>