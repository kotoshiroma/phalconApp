<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Phalcon PHP Framework</title>
        <link rel="stylesheet" href="../public/css/bootstrap.css">
        <link rel="stylesheet" href="../public/css/myapp.css">
        <!-- <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->url->get('img/favicon.ico')?>"/> -->
    </head>
    <body class="body">
        {{ partial("partial/header") }}
        <?php echo $this->getContent(); ?>
            
        <script src="../public/js/jquery-3.3.1.js"></script>
        <script src="../public/js/bootstrap.bundle.js"></script>
    </body>
</html>
