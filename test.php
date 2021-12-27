<?php
    require_once 'core/init.php';

    $stock = DB::getInstance()->get('stock');
    echo $stock->results()['ID'];
?>