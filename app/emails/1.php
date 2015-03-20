<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Books | eCommence Online Store</title>
        <meta name="description" content="eCommence Online Store">
        <meta name="viewport" content="width=device-width">
        <meta name="author" content="Kosta Rashev">
    </head>
    <body>
        <p>
            Dear <?php echo $first_name; ?>
        </p>
        <p>
            Thank you for registering at our website.
            <?php if (!empty($password)): ?>
            <br/>Your login details are as follow:
        </p>
        <p>
            Login: <?php echo $email; ?><br/>
            Password: <?php echo $password; ?>
        </p>

        <?php else: ?>
</p>
<?php endif; ?>
        <p>
            In order to activate your account, please click on the following link:
        </p>
        <p>
            <?php echo $link; ?>
        </p>
    </body>
</html>