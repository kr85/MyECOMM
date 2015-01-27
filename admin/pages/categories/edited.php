<?php
    $url = '/admin' . Url::getCurrentUrl(['action', 'id']);

    require_once('templates/_header.php');
?>

    <h1>Categories :: Edit</h1>
    <p>
        The category has been updated successfully.<br/>
        <a href="<?php echo $url ?>">
            Go back to the list of categories.
        </a>
    </p>

<?php require_once('templates/_header.php'); ?>