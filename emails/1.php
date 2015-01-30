<p>
    Dear <?php echo $first_name; ?>
</p>

<p>
    Thank you for registering at our website.

<?php if (!empty($password)) { ?>
    <br/>Your login details are as follow:
</p>
<p>
    Login: <?php echo $email; ?><br/>
    Password: <?php echo $password; ?>
</p>

<?php } else { ?>

</p>

<?php } ?>

<p>
    In order to activate your account, please click on the following link:
</p>

<p>
    <?php echo $link; ?>
</p>