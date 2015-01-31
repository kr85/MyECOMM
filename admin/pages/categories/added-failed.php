<?php
    $url = $this->objUrl->getCurrent(['action', 'id']);

    require_once('_header.php');
?>

    <h1>Categories :: Add</h1>
    <p>
        There was a problem adding this category.
        Please contact the administrator.<br/>
        <a href="<?php echo $url; ?>">
            Go back to the list of categories.
        </a>
    </p>

<?php require_once('_header.php'); ?>