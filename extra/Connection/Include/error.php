<?php if(PHP_SAPI === "cli"): ?>
    <?php echo "$_error\n"; ?>
<?php else: ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../extra/Resource/img/warframe.svg" type="image/x-icon">
        <title>Connection error</title>
    </head>
    <body>
        <center style="margin-top: 30px;">
            <strong><em>Warframe</em></strong>
            <hr width="50%">
            <h1><?= $_error ?></h1>
        </center>
    </body>
    </html>
<?php endif; ?>