<?php if(PHP_SAPI === "cli"): ?>
    <?php echo "$_error\n"; ?>
<?php else: ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?= str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__)) ?>/Resource/img/warframe.png" type="image/x-icon">
        <title><?= $_error ?></title>
    </head>
    <body>
        <center>
            <img src="<?= str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__)) ?>/Resource/img/warframe.png" alt=""><br>
            <strong style="font-size:20px"><em>Warframe</em></strong>
            <hr width="50%">
            <h1><?= $_error ?></h1>
        </center>
    </body>
    </html>
<?php endif; ?>