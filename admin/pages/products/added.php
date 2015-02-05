<?php
    $url = $this->objUrl->get(['action', 'id']);

    require_once('_header.php');
?>

    <h1>Products :: Add</h1>
    <p>
        The new product has been added successfully.<br/>
        <a href="<?php echo $url ?>">
            Go back to the list of products.
        </a>
    </p>

<?php require_once('_header.php'); ?>