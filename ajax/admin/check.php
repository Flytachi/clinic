<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);

include 'download_logo.php';

$_SESSION['message'] .= '
<div class="alert alert-primary" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
    Данные внесены.
</div>
';

render();
?>